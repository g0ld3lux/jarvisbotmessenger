<?php

namespace App\Policies;

use App\Models\Flow;
use App\Models\Bot;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FlowPolicy
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
    protected function iFlowRelatedToBot(Flow $flow, Bot $bot)
    {
        return $flow->bot_id == $bot->id;
    }

    /**
     * Determine if user can view.
     *
     * @param User $user
     * @param Flow $flow
     * @param Bot $bot
     * @return bool
     */
    public function view(User $user, Flow $flow, Bot $bot)
    {
        return $this->isBotOwner($user, $bot) && $this->iFlowRelatedToBot($flow, $bot);
    }

    /**
     * Determine if user can edit.
     *
     * @param User $user
     * @param Flow $flow
     * @param Bot $bot
     * @return bool
     */
    public function edit(User $user, Flow $flow, Bot $bot)
    {
        return $this->isBotOwner($user, $bot) && $this->iFlowRelatedToBot($flow, $bot);
    }

    /**
     * Determine if user can view.
     *
     * @param User $user
     * @param Flow $flow
     * @param Bot $bot
     * @return bool
     */
    public function delete(User $user, Flow $flow, Bot $bot)
    {
        return $this->isBotOwner($user, $bot) && $this->iFlowRelatedToBot($flow, $bot);
    }
}
