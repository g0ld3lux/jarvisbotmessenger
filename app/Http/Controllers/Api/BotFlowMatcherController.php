<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Matcher\StoreRequest;
use App\Http\Requests\Api\Matcher\UpdateRequest;
use App\Jobs\Flows\Matchers\AssignParamsJob;
use App\Models\Flow;
use App\Models\Bot;
use Illuminate\Contracts\Bus\Dispatcher;

class BotFlowMatcherController extends Controller
{
    /**
     * Remove matcher.
     *
     * @param Bot $bot
     * @param Flow $flow
     * @param Flow\Matcher $matcher
     * @return Bot
     */
    public function destroy(Bot $bot, Flow $flow, Flow\Matcher $matcher)
    {
        $this->authorize('delete', [$matcher, $flow, $bot]);

        $matcher->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Store new matcher.
     *
     * @param StoreRequest $request
     * @param Dispatcher $dispatcher
     * @param Bot $bot
     * @param Flow $flow
     * @return Flow\Matcher
     */
    public function store(StoreRequest $request, Dispatcher $dispatcher, Bot $bot, Flow $flow)
    {
        $this->authorize('edit', [$flow, $bot]);

        $matcher = new Flow\Matcher(['type' => $request->get('type')]);
        $matcher->flow()->associate($flow);
        $matcher->save();

        $dispatcher->dispatchNow(new AssignParamsJob($matcher, $request));

        return $matcher;
    }

    /**
     * Update matcher.
     *
     * @param UpdateRequest $request
     * @param Dispatcher $dispatcher
     * @param Bot $bot
     * @param Flow $flow
     * @param Flow\Matcher $matcher
     * @return Flow\Matcher
     */
    public function update(
        UpdateRequest $request,
        Dispatcher $dispatcher,
        Bot $bot,
        Flow $flow,
        Flow\Matcher $matcher
    ) {
        $this->authorize('edit', [$matcher, $flow, $bot]);

        $matcher->touch();

        $dispatcher->dispatchNow(new AssignParamsJob($matcher, $request));

        return $matcher;
    }
}
