<?php

namespace App\Http\Controllers\Api\Bot\Subscription\Channel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Bot\Subscription\Channel\Broadcast\StoreRequest;
use App\Jobs\Subscription\Channel\Broadcast\ScheduleJob;
use App\Models\Bot;
use App\Models\Subscription\Channel;
use Carbon\Carbon;
use Datatables;
use Illuminate\Contracts\Bus\Dispatcher;

class BroadcastController extends Controller
{
    /**
     * @param Bot $bot
     * @param Channel $channel
     * @return mixed
     */
    public function index(Bot $bot, Channel $channel)
    {
        $this->authorize('view', [$channel, $bot]);

        return Datatables::of($channel->broadcasts())->make(true);
    }

    /**
     * @param Bot $bot
     * @param Channel $channel
     * @param Channel\Broadcast $broadcast
     * @return Channel\Broadcast
     */
    public function show(Bot $bot, Channel $channel, Channel\Broadcast $broadcast)
    {
        $this->authorize('view', [$broadcast, $channel, $bot]);

        $broadcast->load('respond');

        return $broadcast;
    }

    /**
     * @param Dispatcher $dispatcher
     * @param StoreRequest $request
     * @param Bot $bot
     * @param Channel $channel
     * @return Channel\Broadcast
     */
    public function store(Dispatcher $dispatcher, StoreRequest $request, Bot $bot, Channel $channel)
    {
        $this->authorize('view', [$channel, $bot]);

        $currentTZ = date_default_timezone_get();

        date_default_timezone_set($bot->timezone);

        $scheduledAt = new Carbon($request->get('scheduled_at'));
        $scheduledAt->setTimezone($currentTZ);

        date_default_timezone_set($currentTZ);

        $broadcast = new Channel\Broadcast([
            'name' => $request->get('name'),
            'scheduled_at' => new Carbon($scheduledAt),
        ]);

        $broadcast->channel()->associate($channel);
        $broadcast->respond()->associate($bot->responds()->findOrFail($request->get('respond')));

        $broadcast->save();

        $dispatcher->dispatchNow(new ScheduleJob(
            $broadcast,
            (int) $request->get('interval', 0),
            $request->get('timezone')
        ));

        return $broadcast;
    }

    /**
     * @param Bot $bot
     * @param Channel $channel
     * @param Channel\Broadcast $broadcast
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Bot $bot, Channel $channel, Channel\Broadcast $broadcast)
    {
        $this->authorize('delete', [$broadcast, $channel, $bot]);

        $broadcast->delete();

        return response()->json(['success' => true]);
    }
}
