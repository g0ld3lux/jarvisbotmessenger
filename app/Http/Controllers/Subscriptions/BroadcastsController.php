<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use App\Models\Bot;
use App\Models\Subscription\Channel;

class BroadcastsController extends Controller
{
    /**
     * @param Bot $bot
     * @param Channel $channel
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Bot $bot, Channel $channel)
    {
        $this->authorize('view', [$channel, $bot]);

        return view('bots.subscriptions.channels.broadcasts.create', [
            'bot' => $bot,
            'channel' => $channel,
            'responds' => $bot->responds()->get(),
        ]);
    }

    /**
     * @param Bot $bot
     * @param Channel $channel
     * @param Channel\Broadcast $broadcast
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Bot $bot, Channel $channel, Channel\Broadcast $broadcast)
    {
        $this->authorize('view', [$broadcast, $channel, $bot]);

        return view('bots.subscriptions.channels.broadcasts.show', [
            'bot' => $bot,
            'channel' => $channel,
            'broadcast' => $broadcast,
        ]);
    }
}
