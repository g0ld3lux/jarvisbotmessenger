<?php

namespace App\Jobs\Subscription\Channel;

use App\Jobs\Job;
use App\Models\Statistic;
use App\Models\Subscription\Channel;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IncreaseMessagesSentCount extends Job
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var Channel
     */
    protected $channel;

    /**
     * @var int
     */
    protected $delta;

    /**
     * @var Carbon
     */
    protected $date;

    /**
     * @param Channel $channel
     * @param int $delta
     * @param null|Carbon $date
     */
    public function __construct(Channel $channel, $delta = 1, Carbon $date = null)
    {
        $this->channel = $channel;
        $this->delta = $delta;
        $this->date = is_null($date) ? new Carbon() : $date;
    }

    /**
     * Handle job.
     */
    public function handle()
    {
        $existing = $this
            ->channel
            ->statistics()
            ->where('key', 'broadcast_messages_sent')
            ->where('date_at', $this->date->format('Y-m-d'))
            ->first();

        if ($existing) {
            $existing->update(['value' => $existing->value + $this->delta]);
        } else {
            $this
                ->channel
                ->statistics()
                ->save(new Statistic([
                    'key' => 'broadcast_messages_sent',
                    'value' => $this->delta,
                    'date_at' => $this->date,
                ]));
        }
    }
}
