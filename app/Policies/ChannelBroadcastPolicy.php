<?php

namespace App\Policies;

use App\Models\Bot;
use App\Models\Respond;
use App\Models\Subscription\Channel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChannelBroadcastPolicy
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
     * @param Channel\Broadcast $broadcast
     * @param Channel $channel
     * @return bool
     */
    protected function isBroadcastRelatedToChannel(Channel\Broadcast $broadcast, Channel $channel)
    {
        return $broadcast->channel_id == $channel->id;
    }

    /**
     * @param User $user
     * @param Channel\Broadcast $broadcast
     * @param Channel $channel
     * @param Bot $bot
     * @return bool
     */
    public function view(User $user, Channel\Broadcast $broadcast, Channel $channel, Bot $bot)
    {
        return $this->isBotOwner($user, $bot)
            && $this->isChannelRelatedToBot($channel, $bot)
            && $this->isBroadcastRelatedToChannel($broadcast, $channel);
    }

    /**
     * @param User $user
     * @param Channel\Broadcast $broadcast
     * @param Channel $channel
     * @param Bot $bot
     * @return bool
     */
    public function delete(User $user, Channel\Broadcast $broadcast, Channel $channel, Bot $bot)
    {
        return $this->isBotOwner($user, $bot)
            && $this->isChannelRelatedToBot($channel, $bot)
            && $this->isBroadcastRelatedToChannel($broadcast, $channel)
            && !$broadcast->is_started
            && !$broadcast->is_finished;
    }
}
