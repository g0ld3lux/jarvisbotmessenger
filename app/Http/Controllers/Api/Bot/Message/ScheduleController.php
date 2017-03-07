<?php

namespace App\Http\Controllers\Api\Bot\Message;

use App\Http\Controllers\Controller;
use App\Models\Mass\Message;
use App\Models\Bot;
use Datatables;

class ScheduleController extends Controller
{
    /**
     * @param Bot $bot
     * @param Message $message
     * @return mixed
     */
    public function index(Bot $bot, Message $message)
    {
        $this->authorize('view', [$message, $bot]);

        return Datatables::of(
            Message\Schedule::with('recipient')->where('mass_message_id', $message->id)
        )->make(true);
    }
}
