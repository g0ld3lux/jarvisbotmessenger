<?php

namespace App\Policies;

use App\Models\Flow;
use App\Models\Mass\Message;
use App\Models\Bot;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Bot $bot
     * @return bool
     */
    protected function isBotOwner(User $user, Bot $bot)
    {
        return $user->id == $bot->user_id;
    }

    /**
     * @param Message $message
     * @param Bot $bot
     * @return bool
     */
    protected function isMessageRelatedToBot(Message $message, Bot $bot)
    {
        return $message->bot_id == $bot->id;
    }

    /**
     * @param User $user
     * @param Message $message
     * @param Bot $bot
     * @return bool
     */
    public function view(User $user, Message $message, Bot $bot)
    {
        return $this->isBotOwner($user, $bot) && $this->isMessageRelatedToBot($message, $bot);
    }

    /**
     * @param User $user
     * @param Message $message
     * @param Bot $bot
     * @return bool
     */
    public function delete(User $user, Message $message, Bot $bot)
    {
        return $this->isBotOwner($user, $bot)
            && $this->isMessageRelatedToBot($message, $bot)
            && !$message->is_started
            && !$message->is_finished;
    }
}
