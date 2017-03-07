<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use App\Models\Bot;
use App\Models\Subscription\Channel;
use Notification;

class ChannelsController extends Controller
{
    /**
     * @param Bot $bot
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Bot $bot)
    {
        $this->authorize('view', $bot);

        return view('bots.subscriptions.channels.index', ['bot' => $bot]);
    }

    /**
     * @param Bot $bot
     * @param Channel $channel
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Bot $bot, Channel $channel)
    {
        $this->authorize('view', [$channel, $bot]);

        return view('bots.subscriptions.channels.show', [
            'bot' => $bot,
            'channel' => $channel,
            'broadcasts' => $channel->broadcasts()->ordered()->take(10)->get(),
            'recipients' => $channel->recipients()->orderBy('pivot_created_at', 'desc')->take(10)->get(),
        ]);
    }

    /**
     * @param Bot $bot
     * @param Channel $channel
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Bot $bot, Channel $channel)
    {
        $this->authorize('delete', [$channel, $bot]);

        $channel->delete();

        Notification::success('Subscription channel deleted successfully.');

        return redirect()->route('bots.subscriptions.channels.index', $bot->id);
    }
}
