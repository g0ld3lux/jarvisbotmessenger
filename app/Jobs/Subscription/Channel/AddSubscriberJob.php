<?php

namespace App\Jobs\Subscription\Channel;

use App\Events\Subscription\Channel\SubscriberAddedEvent;
use App\Jobs\Job;
use App\Models\Recipient;
use App\Models\Subscription\Channel;
use Illuminate\Contracts\Events\Dispatcher;

class AddSubscriberJob extends Job
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
     * AddSubscriberJob constructor.
     * @param Channel $channel
     * @param Recipient $recipient
     * @param string $type
     */
    public function __construct(Channel $channel, Recipient $recipient, $type = 'optin')
    {
        $this->channel = $channel;
        $this->recipient = $recipient;
        $this->type = $type;
    }

    /**
     * Handle.
     *
     * @param Dispatcher $dispatcher
     */
    public function handle(Dispatcher $dispatcher)
    {
        try {
            $this->channel->recipients()->attach($this->recipient->id, ['type' => $this->type]);
            $dispatcher->fire(new SubscriberAddedEvent($this->channel, $this->recipient, $this->type));
        } catch (\Exception $e) {
            logger($e);
        }
    }
}
