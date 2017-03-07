<?php

namespace App\Http\Controllers;

use App\Models\Mass\Message;
use App\Models\Bot;

class MassMessagesController extends Controller
{
    /**
     * @param Bot $bot
     * @return \Illuminate\Http\Response
     */
    public function index(Bot $bot)
    {
        $this->authorize('view', $bot);

        return view('bots.messages.index', [
            'bot' => $bot,
        ]);
    }

    /**
     * @param Bot $bot
     * @param Message $message
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Bot $bot, Message $message)
    {
        $this->authorize('view', [$message, $bot]);

        return view('bots.messages.show', [
            'bot' => $bot,
            'message' => $message,
        ]);
    }
}
