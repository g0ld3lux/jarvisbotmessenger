<?php

namespace App\Listeners\Subscription\Channel;

use App\Events\Subscription\Channel\SubscriberAddedEvent;
use App\Jobs\Statistics\Subscription\Channel\IncreaseSubscribersCount;
use Illuminate\Contracts\Bus\Dispatcher;

class IncreaseSubscribersCountListener
{
    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * IncreaseProjectMessagesPostedCountListener constructor.
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param SubscriberAddedEvent $event
     */
    public function handle(SubscriberAddedEvent $event)
    {
        $channel = $event->getChannel();

        if ($channel) {
            $this->dispatcher->dispatch(new IncreaseSubscribersCount($channel));
        }
    }
}
