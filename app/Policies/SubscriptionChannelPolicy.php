<?php

namespace App\Policies;

use App\Models\Bot;
use App\Models\Respond;
use App\Models\Subscription\Channel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscriptionChannelPolicy
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
     * @param Channel $channel
     * @param Bot $bot
     * @return bool
     */
    protected function isChannelRelatedToBot(Channel $channel, Bot $bot)
    {
        return $channel->bot_id == $bot->id;
    }

    /**
     * @param User $user
     * @param Channel $channel
     * @param Bot $bot
     * @return bool
     */
    public function view(User $user, Channel $channel, Bot $bot)
    {
        return $this->isBotOwner($user, $bot) && $this->isChannelRelatedToBot($channel, $bot);
    }

    /**
     * @param User $user
     * @param Channel $channel
     * @param Bot $bot
     * @return bool
     */
    public function edit(User $user, Channel $channel, Bot $bot)
    {
        return $this->isBotOwner($user, $bot) && $this->isChannelRelatedToBot($channel, $bot);
    }

    /**
     * @param User $user
     * @param Channel $channel
     * @param Bot $bot
     * @return bool
     */
    public function delete(User $user, Channel $channel, Bot $bot)
    {
        return $this->isBotOwner($user, $bot) && $this->isChannelRelatedToBot($channel, $bot);
    }
}
