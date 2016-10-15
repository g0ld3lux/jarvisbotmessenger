<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Subscription\Channel;
use Notification;

class ChannelsController extends Controller
{
    /**
     * @param Project $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Project $project)
    {
        $this->authorize('view', $project);

        return view('projects.subscriptions.channels.index', ['project' => $project]);
    }

    /**
     * @param Project $project
     * @param Channel $channel
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Project $project, Channel $channel)
    {
        $this->authorize('view', [$channel, $project]);

        return view('projects.subscriptions.channels.show', [
            'project' => $project,
            'channel' => $channel,
            'broadcasts' => $channel->broadcasts()->ordered()->take(10)->get(),
            'recipients' => $channel->recipients()->orderBy('pivot_created_at', 'desc')->take(10)->get(),
        ]);
    }

    /**
     * @param Project $project
     * @param Channel $channel
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Project $project, Channel $channel)
    {
        $this->authorize('delete', [$channel, $project]);

        $channel->delete();

        Notification::success('Subscription channel deleted successfully.');

        return redirect()->route('projects.subscriptions.channels.index', $project->id);
    }
}
