<?php

namespace App\Http\Controllers\Api\Bot\Subscription;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Bot\Subscription\Channel\StoreRequest;
use App\Http\Requests\Api\Bot\Subscription\Channel\UpdateRequest;
use App\Models\Bot;
use App\Models\Subscription\Channel;
use Datatables;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    /**
     * @param Request $request
     * @param Bot $bot
     * @return mixed
     */
    public function index(Request $request, Bot $bot)
    {
        $this->authorize('view', [$bot]);

        if ($request->get('all', false)) {
            return $bot->subscriptionsChannels()->get();
        }

        return Datatables::of($bot->subscriptionsChannels())->make(true);
    }

    /**
     * @param StoreRequest $request
     * @param Bot $bot
     * @return Channel
     */
    public function store(StoreRequest $request, Bot $bot)
    {
        $this->authorize('view', $bot);

        $channel = new Channel(['name' => $request->get('name')]);

        $channel->bot()->associate($bot);

        $channel->save();

        return $channel;
    }

    /**
     * @param UpdateRequest $request
     * @param Bot $bot
     * @param Channel $channel
     * @return Channel
     */
    public function update(UpdateRequest $request, Bot $bot, Channel $channel)
    {
        $this->authorize('view', [$channel, $bot]);

        $channel->fill(['name' => $request->get('name')]);
        $channel->save();

        return $channel;
    }

    /**
     * @param Bot $bot
     * @param Channel $channel
     * @return Channel
     */
    public function show(Bot $bot, Channel $channel)
    {
        $this->authorize('view', [$channel, $bot]);

        return $channel;
    }

    /**
     * @param Bot $bot
     * @param Channel $channel
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Bot $bot, Channel $channel)
    {
        $this->authorize('view', [$channel, $bot]);

        $channel->delete();

        return response()->json(['success' => true]);
    }
}
