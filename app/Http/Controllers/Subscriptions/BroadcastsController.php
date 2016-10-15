<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Subscription\Channel;

class BroadcastsController extends Controller
{
    /**
     * @param Project $project
     * @param Channel $channel
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Project $project, Channel $channel)
    {
        $this->authorize('view', [$channel, $project]);

        return view('projects.subscriptions.channels.broadcasts.create', [
            'project' => $project,
            'channel' => $channel,
            'responds' => $project->responds()->get(),
        ]);
    }

    /**
     * @param Project $project
     * @param Channel $channel
     * @param Channel\Broadcast $broadcast
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Project $project, Channel $channel, Channel\Broadcast $broadcast)
    {
        $this->authorize('view', [$broadcast, $channel, $project]);

        return view('projects.subscriptions.channels.broadcasts.show', [
            'project' => $project,
            'channel' => $channel,
            'broadcast' => $broadcast,
        ]);
    }
}
