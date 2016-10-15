<?php

namespace App\Events\Subscription\Channel;

use App\Events\Event;
use App\Models\Recipient;
use App\Models\Subscription\Channel;

class SubscriberAddedEvent extends Event
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
     * @var string
     */
    protected $type;

    /**
     * @param Channel $channel
     * @param Recipient $recipient
     * @param string $type
     */
    public function __construct(Channel $channel, Recipient $recipient, $type)
    {
        $this->channel = $channel;
        $this->recipient = $recipient;
        $this->type = $type;
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

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
