<?php

namespace App\Policies;

use App\Models\Bot;
use App\Models\Recipient;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecipientPolicy
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
     * @param Recipient $recipient
     * @param Bot $bot
     * @return bool
     */
    protected function isRecipientRelatedToBot(Recipient $recipient, Bot $bot)
    {
        return $recipient->bot_id == $bot->id;
    }

    /**
     * Determine if user can view.
     *
     * @param User $user
     * @param Recipient $recipient
     * @param Bot $bot
     * @return bool
     */
    public function view(User $user, Recipient $recipient, Bot $bot)
    {
        return $this->isBotOwner($user, $bot) && $this->isRecipientRelatedToBot($recipient, $bot);
    }

    /**
     * @param User $user
     * @param Recipient $recipient
     * @param Bot $bot
     * @return bool
     */
    public function edit(User $user, Recipient $recipient, Bot $bot)
    {
        return $this->isBotOwner($user, $bot) && $this->isRecipientRelatedToBot($recipient, $bot);
    }
}
