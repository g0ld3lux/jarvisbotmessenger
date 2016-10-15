<?php

namespace App\Http\Controllers\Api\Project\Subscription\Channel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Project\Subscription\Channel\Broadcast\StoreRequest;
use App\Jobs\Subscription\Channel\Broadcast\ScheduleJob;
use App\Models\Project;
use App\Models\Subscription\Channel;
use Carbon\Carbon;
use Datatables;
use Illuminate\Contracts\Bus\Dispatcher;

class BroadcastController extends Controller
{
    /**
     * @param Project $project
     * @param Channel $channel
     * @return mixed
     */
    public function index(Project $project, Channel $channel)
    {
        $this->authorize('view', [$channel, $project]);

        return Datatables::of($channel->broadcasts())->make(true);
    }

    /**
     * @param Project $project
     * @param Channel $channel
     * @param Channel\Broadcast $broadcast
     * @return Channel\Broadcast
     */
    public function show(Project $project, Channel $channel, Channel\Broadcast $broadcast)
    {
        $this->authorize('view', [$broadcast, $channel, $project]);

        $broadcast->load('respond');

        return $broadcast;
    }

    /**
     * @param Dispatcher $dispatcher
     * @param StoreRequest $request
     * @param Project $project
     * @param Channel $channel
     * @return Channel\Broadcast
     */
    public function store(Dispatcher $dispatcher, StoreRequest $request, Project $project, Channel $channel)
    {
        $this->authorize('view', [$channel, $project]);

        $currentTZ = date_default_timezone_get();

        date_default_timezone_set($project->timezone);

        $scheduledAt = new Carbon($request->get('scheduled_at'));
        $scheduledAt->setTimezone($currentTZ);

        date_default_timezone_set($currentTZ);

        $broadcast = new Channel\Broadcast([
            'name' => $request->get('name'),
            'scheduled_at' => new Carbon($scheduledAt),
        ]);

        $broadcast->channel()->associate($channel);
        $broadcast->respond()->associate($project->responds()->findOrFail($request->get('respond')));

        $broadcast->save();

        $dispatcher->dispatchNow(new ScheduleJob(
            $broadcast,
            (int) $request->get('interval', 0),
            $request->get('timezone')
        ));

        return $broadcast;
    }

    /**
     * @param Project $project
     * @param Channel $channel
     * @param Channel\Broadcast $broadcast
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Project $project, Channel $channel, Channel\Broadcast $broadcast)
    {
        $this->authorize('delete', [$broadcast, $channel, $project]);

        $broadcast->delete();

        return response()->json(['success' => true]);
    }
}
