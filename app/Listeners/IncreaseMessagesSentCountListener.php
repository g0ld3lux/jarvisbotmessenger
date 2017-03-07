<?php

namespace App\Listeners;

use App\Events\ScheduleProcessedEvent;
use App\Jobs\Statistics\Bots\IncreaseMessageSentCount;
use Illuminate\Contracts\Bus\Dispatcher;

class IncreaseMessagesSentCountListener
{
    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * IncreaseBotMessagesPostedCountListener constructor.
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param ScheduleProcessedEvent $event
     */
    public function handle(ScheduleProcessedEvent $event)
    {
        $message = $event->getSchedule()->message;

        if ($message && $message->bot) {
            $this->dispatcher->dispatch(new IncreaseMessageSentCount($message->bot));
        }
    }
}
