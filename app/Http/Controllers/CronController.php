<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessScheduleJob;
use App\Jobs\Subscription\Channel\Broadcast\ProcessScheduleJob as ProcesBroadcastScheduleJob;
use App\Models\Mass\Message\Schedule;
use App\Models\Subscription\Channel\Broadcast;
use Carbon\Carbon;
use Illuminate\Contracts\Bus\Dispatcher;

class CronController extends Controller
{
    /**
     * @param Dispatcher $dispatcher
     * @return \Illuminate\Http\Response
     */
    public function processScheduledMessages(Dispatcher $dispatcher)
    {
        while ($schedule = $this->scheduledMessageEntry()) {
            $schedule->started_at = new Carbon();
            $schedule->save();
            $dispatcher->dispatch(new ProcessScheduleJob($schedule));
        }

        return 'DONE';
    }

    /**
     * @return Schedule
     */
    protected function scheduledMessageEntry()
    {
        return Schedule::whereNull('sent_at')
            ->whereNull('paused_at')
            ->whereNull('started_at')
            ->where('scheduled_at', '<=', new Carbon())
            ->first();
    }

    /**
     * @param Dispatcher $dispatcher
     * @return \Illuminate\Http\Response
     */
    public function processBroadcastMessages(Dispatcher $dispatcher)
    {
        while ($schedule = $this->broadcastMessageEntry()) {
            $schedule->started_at = new Carbon();
            $schedule->save();
            $dispatcher->dispatch(new ProcesBroadcastScheduleJob($schedule));
        }

        return 'DONE';
    }

    /**
     * @return Broadcast\Schedule
     */
    protected function broadcastMessageEntry()
    {
        return Broadcast\Schedule::whereNull('sent_at')
            ->whereNull('paused_at')
            ->whereNull('started_at')
            ->where('scheduled_at', '<=', new Carbon())
            ->first();
    }
}
