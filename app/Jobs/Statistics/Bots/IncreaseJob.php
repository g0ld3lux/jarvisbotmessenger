<?php

namespace App\Jobs\Statistics\Bots;

use App\Jobs\Job;
use App\Models\Bot;
use App\Models\Statistic;
use Carbon\Carbon;

abstract class IncreaseJob extends Job
{
    /**
     * @var Bot
     */
    protected $bot;

    /**
     * @var int
     */
    protected $delta;

    /**
     * @var Carbon
     */
    protected $date;

    /**
     * IncreaseMatchedRespondCount constructor.
     * @param Bot $bot
     * @param int $delta
     * @param null|Carbon $date
     */
    public function __construct(Bot $bot, $delta = 1, Carbon $date = null)
    {
        $this->bot = $bot;
        $this->delta = $delta;
        $this->date = is_null($date) ? new Carbon() : $date;
    }

    /**
     * Return statistic key.
     *
     * @return string
     */
    abstract protected function statisticKey();

    /**
     * Handle job.
     */
    public function handle()
    {
        $existing = $this
            ->bot
            ->statistics()
            ->where('key', $this->statisticKey())
            ->where('date_at', $this->date->format('Y-m-d'))
            ->first();

        if ($existing) {
            $existing->update(['value' => $existing->value + $this->delta]);
        } else {
            $this
                ->bot
                ->statistics()
                ->save(new Statistic([
                    'key' => $this->statisticKey(),
                    'value' => $this->delta,
                    'date_at' => $this->date,
                ]));
        }
    }
}
