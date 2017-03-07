<?php

namespace App\Policies;

use App\Models\Bot;
use App\Models\Respond;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RespondPolicy
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
     * @param Respond $respond
     * @param Bot $bot
     * @return bool
     */
    protected function isRespondRelatedToBot(Respond $respond, Bot $bot)
    {
        return $respond->bot_id == $bot->id;
    }

    /**
     * Determine if user can view.
     *
     * @param User $user
     * @param Respond $respond
     * @param Bot $bot
     * @return bool
     */
    public function view(User $user, Respond $respond, Bot $bot)
    {
        return $this->isBotOwner($user, $bot) && $this->isRespondRelatedToBot($respond, $bot);
    }

    /**
     * Determine if user can edit.
     *
     * @param User $user
     * @param Respond $respond
     * @param Bot $bot
     * @return bool
     */
    public function edit(User $user, Respond $respond, Bot $bot)
    {
        return $this->isBotOwner($user, $bot) && $this->isRespondRelatedToBot($respond, $bot);
    }

    /**
     * Determine if user can view.
     *
     * @param User $user
     * @param Respond $respond
     * @param Bot $bot
     * @return bool
     */
    public function delete(User $user, Respond $respond, Bot $bot)
    {
        return $this->isBotOwner($user, $bot) && $this->isRespondRelatedToBot($respond, $bot);
    }
}
