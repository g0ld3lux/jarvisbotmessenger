<?php

namespace App\Http\Controllers;

use App\Http\Requests\Recipient\Variable\CreateRequest;
use App\Http\Requests\Recipient\Variable\UpdateRequest;
use App\Models\Bot;
use App\Models\Recipient;
use App\Models\Communication;
use Illuminate\Support\Str;
use Notification;

class RecipientsVariablesController extends Controller
{
    /**
     * Show links list.
     *
     * @param Bot $bot
     * @return \Illuminate\Http\Response
     */
    public function index(Bot $bot)
    {
        $this->authorize('view', $bot);

        $recipientsVariables = $bot->recipientsVariables()->orderBy('name', 'asc')->get();

        return view('bots.recipients.variables.index', [
            'bot' => $bot,
            'recipientsVariables' => $recipientsVariables,
        ]);
    }

    /**
     * @param Bot $bot
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Bot $bot)
    {
        $this->authorize('view', $bot);

        return view('bots.recipients.variables.create', [
            'bot' => $bot,
        ]);
    }

    /**
     * @param CreateRequest $request
     * @param Bot $bot
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request, Bot $bot)
    {
        $this->authorize('view', $bot);

        $recipientVariable = new Recipient\Variable([
            'name' => $request->get('name'),
            'accessor' => Str::slug($request->get('name')),
            'type' => $request->get('type'),
        ]);

        $recipientVariable->bot()->associate($bot);

        $recipientVariable->save();

        Notification::success('Recipient variable added successfully.');

        return redirect()->route('bots.recipients.variables.index', $bot->id);
    }

    /**
     * @param Bot $bot
     * @param Recipient\Variable $variable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Bot $bot, Recipient\Variable $variable)
    {
        $this->authorize('edit', [$variable, $bot]);

        return view('bots.recipients.variables.edit', [
            'bot' => $bot,
            'recipientVariable' => $variable,
        ]);
    }

    /**
     * @param UpdateRequest $request
     * @param Bot $bot
     * @param Recipient\Variable $variable
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, Bot $bot, Recipient\Variable $variable)
    {
        $this->authorize('edit', [$variable, $bot]);

        $variable->fill([
            'name' => $request->get('name'),
            'accessor' => Str::slug($request->get('name')),
            'type' => $request->get('type'),
        ]);

        $variable->save();

        Notification::success('Recipient variable updated successfully');

        return redirect()->route('bots.recipients.variables.index', $bot->id);
    }

    public function delete(Bot $bot, Recipient\Variable $variable)
    {
        $this->authorize('delete', [$variable, $bot]);

        $variable->delete();

        Notification::success('Recipient variable deleted successfully.');

        return redirect()->route('bots.recipients.variables.index', $bot->id);
    }
}
