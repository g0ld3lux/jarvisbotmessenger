<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Bot\ConnectPageRequest;
use App\Jobs\Facebook\FetchLongLivedTokenJob;
use App\Jobs\Facebook\SubscribeBotJob;
use App\Models\Bot;
use Carbon\Carbon;
use Illuminate\Contracts\Bus\Dispatcher;
use App\Services\Statistics;
use Illuminate\Http\Request;

class BotController extends Controller
{
    /**
     * Return bot.
     *
     * @param Bot $bot
     * @return Bot
     */
    public function show(Bot $bot)
    {
        $this->authorize('view', $bot);

        return $bot;
    }

    /**
     * Connect facebook page.
     *
     * @param ConnectPageRequest $request
     * @param Dispatcher $dispatcher
     * @param Bot $bot
     * @return Bot
     */
    public function connectPage(ConnectPageRequest $request, Dispatcher $dispatcher, Bot $bot)
    {
        $this->authorize('settings', $bot);

        $page = $request->get('page');

        $token = $dispatcher->dispatchNow(new FetchLongLivedTokenJob(array_get($page, 'access_token')));

        $bot->fill([
            'page_title' => array_get($page, 'name'),
            'page_id' => array_get($page, 'id'),
            'page_token' => array_get($token, 'token'),
            'page_token_expires_at' => array_get($token, 'expires'),
        ]);

        $bot->save();

        if (!$dispatcher->dispatchNow(new SubscribeBotJob($bot))) {
            $bot->fill([
                'page_title' => null,
                'page_id' => null,
                'page_token' => null,
                'page_token_expires_at' => null,
            ]);

            $bot->save();

            return response()->json(['success' => false], 422);
        }

        return $bot;
    }

    /**
     * Disconnect facebook page.
     *
     * @param Bot $bot
     * @return \Illuminate\Http\JsonResponse
     */
    public function disconnectPage(Bot $bot)
    {
        $this->authorize('settings', $bot);

        $bot->fill([
            'page_title' => null,
            'page_id' => null,
            'page_token' => null,
            'page_token_expires_at' => null,
            'app_subscribed' => null,
        ]);

        $bot->save();

        return response()->json(['success' => true]);
    }

    /**
     * Return bot analytics.
     *
     * @param Request $request
     * @param Bot $bot
     * @return mixed
     */
    public function analytics(Request $request, Bot $bot)
    {
        $this->authorize('view', $bot);

        $start = $request->has('start') ? new Carbon($request->get('start')) : null;
        $end = $request->has('end') ? new Carbon($request->get('end')) : null;

        return app(Statistics\Bot::class)->getValues($bot, (array) $request->get('fields', []), $start, $end);
    }
}
