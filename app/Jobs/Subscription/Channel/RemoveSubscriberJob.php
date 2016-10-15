<?php

namespace App\Jobs\Subscription\Channel;

use App\Events\Subscription\Channel\SubscriberRemovedEvent;
use App\Jobs\Job;
use App\Models\Recipient;
use App\Models\Subscription\Channel;
use Illuminate\Contracts\Events\Dispatcher;

class RemoveSubscriberJob extends Job
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
     * AddSubscriberJob constructor.
     * @param Channel $channel
     * @param Recipient $recipient
     */
    public function __construct(Channel $channel, Recipient $recipient)
    {
        $this->channel = $channel;
        $this->recipient = $recipient;
    }

    /**
     * Handle.
     *
     * @param Dispatcher $dispatcher
     */
    public function handle(Dispatcher $dispatcher)
    {
        try {
            $this->channel->recipients()->detach($this->recipient->id);
            $dispatcher->fire(new SubscriberRemovedEvent($this->channel, $this->recipient));
        } catch (\Exception $e) {
            logger($e);
        }
    }
}
