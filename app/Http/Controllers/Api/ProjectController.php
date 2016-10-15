<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Project\ConnectPageRequest;
use App\Jobs\Facebook\FetchLongLivedTokenJob;
use App\Jobs\Facebook\SubscribeProjectJob;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Contracts\Bus\Dispatcher;
use App\Services\Statistics;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Return project.
     *
     * @param Project $project
     * @return Project
     */
    public function show(Project $project)
    {
        $this->authorize('view', $project);

        return $project;
    }

    /**
     * Connect facebook page.
     *
     * @param ConnectPageRequest $request
     * @param Dispatcher $dispatcher
     * @param Project $project
     * @return Project
     */
    public function connectPage(ConnectPageRequest $request, Dispatcher $dispatcher, Project $project)
    {
        $this->authorize('settings', $project);

        $page = $request->get('page');

        $token = $dispatcher->dispatchNow(new FetchLongLivedTokenJob(array_get($page, 'access_token')));

        $project->fill([
            'page_title' => array_get($page, 'name'),
            'page_id' => array_get($page, 'id'),
            'page_token' => array_get($token, 'token'),
            'page_token_expires_at' => array_get($token, 'expires'),
        ]);

        $project->save();

        if (!$dispatcher->dispatchNow(new SubscribeProjectJob($project))) {
            $project->fill([
                'page_title' => null,
                'page_id' => null,
                'page_token' => null,
                'page_token_expires_at' => null,
            ]);

            $project->save();

            return response()->json(['success' => false], 422);
        }

        return $project;
    }

    /**
     * Disconnect facebook page.
     *
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse
     */
    public function disconnectPage(Project $project)
    {
        $this->authorize('settings', $project);

        $project->fill([
            'page_title' => null,
            'page_id' => null,
            'page_token' => null,
            'page_token_expires_at' => null,
            'app_subscribed' => null,
        ]);

        $project->save();

        return response()->json(['success' => true]);
    }

    /**
     * Return project analytics.
     *
     * @param Request $request
     * @param Project $project
     * @return mixed
     */
    public function analytics(Request $request, Project $project)
    {
        $this->authorize('view', $project);

        $start = $request->has('start') ? new Carbon($request->get('start')) : null;
        $end = $request->has('end') ? new Carbon($request->get('end')) : null;

        return app(Statistics\Project::class)->getValues($project, (array) $request->get('fields', []), $start, $end);
    }
}
