<?php

namespace App\Events\Subscription\Channel;

use App\Events\Event;
use App\Models\Recipient;
use App\Models\Subscription\Channel;

class SubscriberRemovedEvent extends Event
{
    /**
     * @var Channel
     */
    protected $channel;

    /**
     * @var Recipient
     */
    protected $recipient;

    /**
     * @param Channel $channel
     * @param Recipient $recipient
     */
    public function __construct(Channel $channel, Recipient $recipient)
    {
        $this->channel = $channel;
        $this->recipient = $recipient;
    }

    /**
     * @return Channel
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @return Recipient
     */
    public function getRecipient()
    {
        return $this->recipient;
    }
}
