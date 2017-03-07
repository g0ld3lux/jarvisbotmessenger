<?php

namespace App\Http\Controllers\Api\Bot\Recipient;

use App\Http\Controllers\Controller;
use App\Models\Bot;
use App\Models\Recipient;
use Datatables;
use App\Models\Communication;

class HistoryController extends Controller
{
    /**
     * @param Bot $bot
     * @param Recipient $recipient
     * @return mixed
     */
    public function index(Bot $bot, Recipient $recipient)
    {
        $this->authorize('view', [$recipient, $bot]);

        return Datatables::of(
            Communication\Log::with('flow')
                ->where('bot_id', $bot->id)
                ->where('recipient_id', $recipient->id)
        )->make(true);
    }
}
