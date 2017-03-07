<?php

namespace App\Policies;

use App\Models\Bot;
use App\Models\Recipient;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecipientVariablePolicy
{
    use HandlesAuthorization;

    /**
     * @var array
     */
    protected $skipNames = ['first-name', 'last-name', 'gender', 'timezone', 'locale'];

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
     * @param Recipient\Variable $variable
     * @param Bot $bot
     * @return bool
     */
    protected function isVariableRelatedToBot(Recipient\Variable $variable, Bot $bot)
    {
        return $variable->bot_id == $bot->id;
    }

    /**
     * @param Recipient\Variable $variable
     * @return bool
     */
    protected function isSkipped(Recipient\Variable $variable)
    {
        return in_array($variable->accessor, $this->skipNames);
    }

    /**
     * @param User $user
     * @param Recipient\Variable $variable
     * @param Bot $bot
     * @return bool
     */
    public function edit(User $user, Recipient\Variable $variable, Bot $bot)
    {
        return $this->isBotOwner($user, $bot)
            && $this->isVariableRelatedToBot($variable, $bot)
            && !$this->isSkipped($variable);
    }

    /**
     * @param User $user
     * @param Recipient\Variable $variable
     * @param Bot $bot
     * @return bool
     */
    public function delete(User $user, Recipient\Variable $variable, Bot $bot)
    {
        return $this->isBotOwner($user, $bot)
        && $this->isVariableRelatedToBot($variable, $bot)
        && !$this->isSkipped($variable);
    }
}
