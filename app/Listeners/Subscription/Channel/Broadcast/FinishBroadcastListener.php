<?php

namespace App\Listeners\Subscription\Channel\Broadcast;

use App\Events\Subscription\Channel\Broadcast\ScheduleProcessedEvent;
use Carbon\Carbon;
use Illuminate\Contracts\Bus\Dispatcher;

class FinishBroadcastListener
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
        $schedule = $event->getSchedule();
        $broadcast = $schedule->broadcast;

        if ($broadcast
            && $broadcast->schedules()->where('id', '!=', $schedule->id)->whereNotNull('finished_at')->count() <= 0) {
            $broadcast->finished_at = new Carbon();
            $broadcast->save();
        }
    }
}
