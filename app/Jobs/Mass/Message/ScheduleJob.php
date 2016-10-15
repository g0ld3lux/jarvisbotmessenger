<?php

namespace App\Jobs\Mass\Message;

use App\Jobs\Job;
use App\Models\Mass\Message;
use App\Models\Recipient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScheduleJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var Message
     */
    protected $message;

    /**
     * @var array
     */
    protected $recipients;

    /**
     * @var int
     */
    protected $interval;

    /**
     * @var string
     */
    protected $timezone;

    /**
     * @param Message $message
     * @param array $recipients
     * @param int $interval
     * @param string $timezone
     */
    public function __construct(Message $message, array $recipients = [], $interval = 0, $timezone = 'project')
    {
        $this->message = $message;
        $this->interval = $interval;
        $this->timezone = $timezone;

        foreach ($recipients as $recipient) {
            $this->addRecipient($recipient);
        }
    }

    /**
     * @param Recipient $recipient
     */
    protected function addRecipient(Recipient $recipient)
    {
        $this->recipients[$recipient->id] = $recipient;
    }

    /**
     * @return void
     */
    public function handle()
    {
        if (count($this->getRecipients()) > 0) {
            $index = 0;
            foreach ($this->getRecipients() as $recipient) {
                $scheduledAt = with(clone $this->message->scheduled_at)->addSeconds($index * $this->interval);

                if ($this->timezone == 'recipient' && $recipient->timezone) {
                    try {
                        $scheduledAt->setTimezone(new \DateTimeZone($recipient->timezone));
                    } catch (\Exception $e) {
                    }
                }

                $schedule = new Message\Schedule([
                    'scheduled_at' => $scheduledAt,
                ]);

                $schedule->recipient()->associate($recipient);
                $schedule->message()->associate($this->message);

                $schedule->save();

                $index++;
            }
        }
    }

    /**
     * @return array
     */
    protected function getRecipients()
    {
        if (count($this->recipients) <= 0) {
            foreach ($this->message->project->recipients as $recipient) {
                $this->addRecipient($recipient);
            }
        }

        return $this->recipients;
    }
}
