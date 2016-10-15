<?php

namespace App\Events;

use App\Models\Mass\Message\Schedule;

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
