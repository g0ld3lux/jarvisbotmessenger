<?php

namespace App\Jobs\Subscription\Channel\Broadcast;

use App\Jobs\Job;
use App\Models\Recipient;
use App\Models\Subscription\Channel\Broadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScheduleJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var Broadcast
     */
    protected $broadcast;

    /**
     * @var int
     */
    protected $interval;

    /**
     * @var string
     */
    protected $timezone;

    /**
     * @param Broadcast $broadcast
     * @param int $interval
     * @param string $timezone
     */
    public function __construct(Broadcast $broadcast, $interval = 0, $timezone = 'bot')
    {
        $this->broadcast = $broadcast;
        $this->interval = $interval;
        $this->timezone = $timezone;
    }

    /**
     * @return void
     */
    public function handle()
    {
        $recipients = $this->broadcast->channel ? $this->broadcast->channel->recipients : [];

        if (count($recipients) > 0) {
            $index = 0;
            foreach ($recipients as $recipient) {
                $scheduledAt = with(clone $this->broadcast->scheduled_at)->addSeconds($index * $this->interval);

                if ($this->timezone == 'recipient' && $recipient->timezone) {
                    try {
                        $scheduledAt->setTimezone(new \DateTimeZone($recipient->timezone));
                    } catch (\Exception $e) {
                    }
                }

                $schedule = new Broadcast\Schedule([
                    'scheduled_at' => $scheduledAt,
                ]);

                $schedule->recipient()->associate($recipient);
                $schedule->broadcast()->associate($this->broadcast);

                $schedule->save();

                $index++;
            }
        }
    }
}
