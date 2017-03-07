<?php

namespace App\Policies;

use App\Models\Bot;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BotPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if user is owner of a bot.
     *
     * @param User $user
     * @param Bot $bot
     * @return bool
     */
    protected function isOwner(User $user, Bot $bot)
    {
        return $user->id == $bot->user_id;
    }

    /**
     * Determine if user can update bot settings.
     *
     * @param User $user
     * @param Bot $bot
     * @return bool
     */
    public function settings(User $user, Bot $bot)
    {
        return $this->isOwner($user, $bot);
    }

    /**
     * Determine if user can delete bot.
     *
     * @param User $user
     * @param Bot $bot
     * @return bool
     */
    public function delete(User $user, Bot $bot)
    {
        return $this->isOwner($user, $bot);
    }

    /**
     * Determine if user can view bot.
     *
     * @param User $user
     * @param Bot $bot
     * @return bool
     */
    public function view(User $user, Bot $bot)
    {
        return $this->isOwner($user, $bot);
    }
}
