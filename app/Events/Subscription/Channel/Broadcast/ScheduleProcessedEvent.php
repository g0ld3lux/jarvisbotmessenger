<?php

namespace App\Events\Subscription\Channel\Broadcast;

use App\Events\Event;
use App\Models\Subscription\Channel\Broadcast\Schedule;

class ScheduleProcessedEvent extends Event
{
    /**
     * @var Schedule
     */
    protected $schedule;

    /**
     * ScheduleProcessedEvent constructor.
     * @param Schedule $schedule
     */
    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * @return Schedule
     */
    public function getSchedule()
    {
        return $this->schedule;
    }
}
