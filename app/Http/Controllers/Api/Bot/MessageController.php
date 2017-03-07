<?php

namespace App\Http\Controllers\Api\Bot;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Bot\Message\StoreRequest;
use App\Jobs\Mass\Message\ScheduleJob;
use App\Models\Mass\Message;
use App\Models\Bot;
use Carbon\Carbon;
use Datatables;
use Illuminate\Contracts\Bus\Dispatcher;

class MessageController extends Controller
{
    /**
     * @param Bot $bot
     * @return mixed
     */
    public function index(Bot $bot)
    {
        $this->authorize('view', $bot);

        return Datatables::of($bot->massMessages())->make(true);
    }

    /**
     * @param StoreRequest $request
     * @param Dispatcher $dispatcher
     * @param Bot $bot
     * @return Message
     */
    public function store(StoreRequest $request, Dispatcher $dispatcher, Bot $bot)
    {
        $this->authorize('view', $bot);

        $currentTZ = date_default_timezone_get();

        date_default_timezone_set($bot->timezone);

        $scheduledAt = new Carbon($request->get('scheduled_at'));
        $scheduledAt->setTimezone($currentTZ);

        date_default_timezone_set($currentTZ);

        $message = new Message([
            'name' => $request->get('name'),
            'scheduled_at' => new Carbon($scheduledAt),
        ]);

        $message->bot()->associate($bot);

        $message->save();

        $message->responds()->sync((array) $request->get('responds', []));

        $dispatcher->dispatchNow(new ScheduleJob(
            $message,
            count((array) $request->get('recipients', [])) > 0
            ? $bot->recipients()->whereIn('id', $request->get('recipients'))->get()->all()
            : [],
            (int) $request->get('interval', 0),
            $request->get('timezone')
        ));

        return $message;
    }

    /**
     * @param Bot $bot
     * @param Message $message
     * @return Message
     */
    public function show(Bot $bot, Message $message)
    {
        $this->authorize('view', [$message, $bot]);

        $message->load('responds');

        return $message;
    }

    /**
     * @param Bot $bot
     * @param Message $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Bot $bot, Message $message)
    {
        $this->authorize('delete', [$message, $bot]);

        $message->delete();

        return response()->json(['success' => true]);
    }
}
