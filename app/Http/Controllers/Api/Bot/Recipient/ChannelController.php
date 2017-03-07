<?php

namespace App\Http\Controllers\Api\Bot\Recipient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Bot\Recipient\Channel\StoreRequest;
use App\Models\Bot;
use App\Models\Recipient;
use App\Models\Subscription\Channel;
use Datatables;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    /**
     * @param Request $request
     * @param Bot $bot
     * @param Recipient $recipient
     * @return mixed
     */
    public function index(Request $request, Bot $bot, Recipient $recipient)
    {
        $this->authorize('view', [$recipient, $bot]);

        if ($request->get('all', false)) {
            return $recipient->subscriptionsChannels()->get();
        }

        return Datatables::of($recipient->subscriptionsChannels())->make(true);
    }

    /**
     * @param Bot $bot
     * @param Recipient $recipient
     * @param Channel $channel
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Bot $bot, Recipient $recipient, Channel $channel)
    {
        $this->authorize('view', [$recipient, $bot]);

        $recipient->subscriptionsChannels()->detach($channel->id);

        return response()->json(['success' => true]);
    }

    /**
     * @param StoreRequest $request
     * @param Bot $bot
     * @param Recipient $recipient
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function store(StoreRequest $request, Bot $bot, Recipient $recipient)
    {
        $this->authorize('view', [$recipient, $bot]);

        foreach ((array) $request->get('channels', []) as $channel) {
            $recipient->subscriptionsChannels()->attach($channel['id'], ['type' => $channel['type']]);
        }

        return $recipient->subscriptionsChannels()->get();
    }
}
