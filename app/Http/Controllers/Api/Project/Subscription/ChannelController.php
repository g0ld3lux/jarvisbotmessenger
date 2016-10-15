<?php

namespace App\Http\Controllers\Api\Project\Subscription;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Project\Subscription\Channel\StoreRequest;
use App\Http\Requests\Api\Project\Subscription\Channel\UpdateRequest;
use App\Models\Project;
use App\Models\Subscription\Channel;
use Datatables;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    /**
     * @param Request $request
     * @param Project $project
     * @return mixed
     */
    public function index(Request $request, Project $project)
    {
        $this->authorize('view', [$project]);

        if ($request->get('all', false)) {
            return $project->subscriptionsChannels()->get();
        }

        return Datatables::of($project->subscriptionsChannels())->make(true);
    }

    /**
     * @param StoreRequest $request
     * @param Project $project
     * @return Channel
     */
    public function store(StoreRequest $request, Project $project)
    {
        $this->authorize('view', $project);

        $channel = new Channel(['name' => $request->get('name')]);

        $channel->project()->associate($project);

        $channel->save();

        return $channel;
    }

    /**
     * @param UpdateRequest $request
     * @param Project $project
     * @param Channel $channel
     * @return Channel
     */
    public function update(UpdateRequest $request, Project $project, Channel $channel)
    {
        $this->authorize('view', [$channel, $project]);

        $channel->fill(['name' => $request->get('name')]);
        $channel->save();

        return $channel;
    }

    /**
     * @param Project $project
     * @param Channel $channel
     * @return Channel
     */
    public function show(Project $project, Channel $channel)
    {
        $this->authorize('view', [$channel, $project]);

        return $channel;
    }

    /**
     * @param Project $project
     * @param Channel $channel
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Project $project, Channel $channel)
    {
        $this->authorize('view', [$channel, $project]);

        $channel->delete();

        return response()->json(['success' => true]);
    }
}
