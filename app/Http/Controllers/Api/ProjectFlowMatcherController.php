<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Matcher\StoreRequest;
use App\Http\Requests\Api\Matcher\UpdateRequest;
use App\Jobs\Flows\Matchers\AssignParamsJob;
use App\Models\Flow;
use App\Models\Project;
use Illuminate\Contracts\Bus\Dispatcher;

class ProjectFlowMatcherController extends Controller
{
    /**
     * Remove matcher.
     *
     * @param Project $project
     * @param Flow $flow
     * @param Flow\Matcher $matcher
     * @return Project
     */
    public function destroy(Project $project, Flow $flow, Flow\Matcher $matcher)
    {
        $this->authorize('delete', [$matcher, $flow, $project]);

        $matcher->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Store new matcher.
     *
     * @param StoreRequest $request
     * @param Dispatcher $dispatcher
     * @param Project $project
     * @param Flow $flow
     * @return Flow\Matcher
     */
    public function store(StoreRequest $request, Dispatcher $dispatcher, Project $project, Flow $flow)
    {
        $this->authorize('edit', [$flow, $project]);

        $matcher = new Flow\Matcher(['type' => $request->get('type')]);
        $matcher->flow()->associate($flow);
        $matcher->save();

        $dispatcher->dispatchNow(new AssignParamsJob($matcher, $request));

        return $matcher;
    }

    /**
     * Update matcher.
     *
     * @param UpdateRequest $request
     * @param Dispatcher $dispatcher
     * @param Project $project
     * @param Flow $flow
     * @param Flow\Matcher $matcher
     * @return Flow\Matcher
     */
    public function update(
        UpdateRequest $request,
        Dispatcher $dispatcher,
        Project $project,
        Flow $flow,
        Flow\Matcher $matcher
    ) {
        $this->authorize('edit', [$matcher, $flow, $project]);

        $matcher->touch();

        $dispatcher->dispatchNow(new AssignParamsJob($matcher, $request));

        return $matcher;
    }
}
