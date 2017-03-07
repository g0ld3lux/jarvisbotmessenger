<?php

namespace App\Http\Controllers;

use App\Http\Requests\Recipient\UpdateRequest;
use App\Jobs\Recipients\AssignVariablesJob;
use App\Models\Bot;
use App\Models\Recipient;
use App\Models\Communication;
use Illuminate\Contracts\Bus\Dispatcher;
use Notification;

class RecipientsController extends Controller
{
    /**
     * @param Bot $bot
     * @return \Illuminate\Http\Response
     */
    public function index(Bot $bot)
    {
        $this->authorize('view', $bot);

        return view('bots.recipients.index', [
            'bot' => $bot,
        ]);
    }

    /**
     * Show bot dashboard.
     *
     * @param Bot $bot
     * @param Recipient $recipient
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Bot $bot, Recipient $recipient)
    {
        $this->authorize('view', [$recipient, $bot]);

        return view('bots.recipients.show', [
            'bot' => $bot,
            'recipient' => $recipient,
        ]);
    }

    /**
     * @param Bot $bot
     * @param Recipient $recipient
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Bot $bot, Recipient $recipient)
    {
        $this->authorize('edit', [$recipient, $bot]);

        $recipientVariables = Recipient\Variable\Relation::with('variable', 'values')
            ->where('recipient_id', $recipient->id)
            ->get()
            ->keyBy(function (Recipient\Variable\Relation $relation) {
                return $relation->variable->accessor;
            });

        return view('bots.recipients.edit', [
            'bot' => $bot,
            'recipient' => $recipient,
            'recipientVariables' => $recipientVariables,
        ]);
    }

    /**
     * @param UpdateRequest $request
     * @param Dispatcher $dispatcher
     * @param Bot $bot
     * @param Recipient $recipient
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, Dispatcher $dispatcher, Bot $bot, Recipient $recipient)
    {
        $this->authorize('edit', [$recipient, $bot]);

        $dispatcher->dispatchNow(new AssignVariablesJob($recipient, (array) $request->get('variables', [])));

        Notification::success('Recipient updated successfully.');

        return redirect()->route('bots.recipients.show', [$bot->id, $recipient->id]);
    }
}
