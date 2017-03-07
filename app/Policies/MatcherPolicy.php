<?php

namespace App\Policies;

use App\Models\Flow;
use App\Models\Bot;
use App\Models\Respond;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MatcherPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if user is owner of a bot.
     *
     * @param User $user
     * @param Bot $bot
     * @return bool
     */
    protected function isBotOwner(User $user, Bot $bot)
    {
        return $user->id == $bot->user_id;
    }

    /**
     * Determine is related to bot.
     *
     * @param Flow $flow
     * @param Bot $bot
     * @return bool
     */
    protected function isFlowRelatedToBot(Flow $flow, Bot $bot)
    {
        return $flow->bot_id == $bot->id;
    }

    /**
     * Determine is related to bot.
     *
     * @param Flow\Matcher $matcher
     * @param Flow $flow
     * @return bool
     */
    protected function isMatcherRelatedToFlow(Flow\Matcher $matcher, Flow $flow)
    {
        return $matcher->flow_id == $flow->id;
    }

    /**
     * Determine if user can edit.
     *
     * @param User $user
     * @param Flow\Matcher $matcher
     * @param Flow $flow
     * @param Bot $bot
     * @return bool
     */
    public function edit(User $user, Flow\Matcher $matcher, Flow $flow, Bot $bot)
    {
        return $this->isBotOwner($user, $bot)
            && $this->isFlowRelatedToBot($flow, $bot)
            && $this->isMatcherRelatedToFlow($matcher, $flow);
    }

    /**
     * Determine if user can delete.
     *
     * @param User $user
     * @param Flow\Matcher $matcher
     * @param Flow $flow
     * @param Bot $bot
     * @return bool
     */
    public function delete(User $user, Flow\Matcher $matcher, Flow $flow, Bot $bot)
    {
        return $this->isBotOwner($user, $bot)
            && $this->isFlowRelatedToBot($flow, $bot)
            && $this->isMatcherRelatedToFlow($matcher, $flow);
    }
}
