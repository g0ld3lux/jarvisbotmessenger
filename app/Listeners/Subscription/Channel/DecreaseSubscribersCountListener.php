<?php

namespace App\Listeners\Subscription\Channel;

use App\Events\Subscription\Channel\SubscriberRemovedEvent;
use App\Jobs\Statistics\Subscription\Channel\DecreaseSubscribersCount;
use Illuminate\Contracts\Bus\Dispatcher;

class DecreaseSubscribersCountListener
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
     * @param SubscriberRemovedEvent $event
     */
    public function handle(SubscriberRemovedEvent $event)
    {
        $channel = $event->getChannel();

        if ($channel) {
            $this->dispatcher->dispatch(new DecreaseSubscribersCount($channel));
        }
    }
}
