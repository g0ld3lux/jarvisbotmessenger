<?php

namespace App\Http\Controllers\Api\Bot;

use App\Http\Controllers\Controller;
use App\Jobs\Recipients\Chat\DisableJob;
use App\Jobs\Recipients\Chat\EnableJob;
use App\Jobs\Recipients\FetchRecipientDataJob;
use App\Models\Bot;
use App\Models\Recipient;
use Datatables;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\Request;

class RecipientController extends Controller
{
    /**
     * @param Request $request
     * @param Bot $bot
     * @return mixed
     */
    public function index(Request $request, Bot $bot)
    {
        $this->authorize('view', $bot);

        if ($request->get('all', false)) {
            return Recipient::where('bot_id', $bot->id)->get();
        }

        return Datatables::of(Recipient::where('bot_id', $bot->id))->make(true);
    }

    /**
     * @param Bot $bot
     * @param Recipient $recipient
     * @return Recipient
     */
    public function show(Bot $bot, Recipient $recipient)
    {
        $this->authorize('view', [$recipient, $bot]);

        $recipient->load(['variables', 'variables.variable', 'variables.values']);

        return $recipient;
    }

    /**
     * @param Dispatcher $dispatcher
     * @param Bot $bot
     * @param Recipient $recipient
     * @return \Illuminate\Http\JsonResponse
     */
    public function disableChat(Dispatcher $dispatcher, Bot $bot, Recipient $recipient)
    {
        $this->authorize('view', [$recipient, $bot]);

        if ($dispatcher->dispatchNow(new DisableJob($recipient))) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 422);
    }

    /**
     * @param Dispatcher $dispatcher
     * @param Bot $bot
     * @param Recipient $recipient
     * @return \Illuminate\Http\JsonResponse
     */
    public function enableChat(Dispatcher $dispatcher, Bot $bot, Recipient $recipient)
    {
        $this->authorize('view', [$recipient, $bot]);

        if ($dispatcher->dispatchNow(new EnableJob($recipient))) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 422);
    }

    /**
     * @param Dispatcher $dispatcher
     * @param Bot $bot
     * @param Recipient $recipient
     * @return \Illuminate\Http\RedirectResponse
     */
    public function refresh(Dispatcher $dispatcher, Bot $bot, Recipient $recipient)
    {
        $this->authorize('view', [$recipient, $bot]);

        $data = $dispatcher->dispatchNow(new FetchRecipientDataJob(
            $recipient->reference,
            $recipient->bot->page_token
        ));

        $recipient->fill([
            'first_name' => array_get($data, 'first_name'),
            'last_name' => array_get($data, 'last_name'),
            'locale' => array_get($data, 'locale'),
            'gender' => array_get($data, 'gender'),
            'timezone' => timezone_gmt_name_from_offset(array_get($data, 'timezone')),
            'photo' => array_get($data, 'profile_pic'),
        ]);

        $recipient->save();

        return $this->show($bot, $recipient);
    }
}
