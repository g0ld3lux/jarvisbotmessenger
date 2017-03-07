<?php

namespace App\Http\Controllers\Api\Bot\Subscription\Channel\Broadcast;

use App\Http\Controllers\Controller;
use App\Models\Bot;
use App\Models\Subscription\Channel;
use Datatables;

class ScheduleController extends Controller
{
    /**
     * @param Bot $bot
     * @param Channel $channel
     * @param Channel\Broadcast $broadcast
     * @return mixed
     */
    public function index(Bot $bot, Channel $channel, Channel\Broadcast $broadcast)
    {
        $this->authorize('view', [$broadcast, $channel, $bot]);

        return Datatables::of(
            Channel\Broadcast\Schedule::with('recipient')->where('broadcast_id', $broadcast->id)
        )->make(true);
    }
}
