<?php

namespace App\Jobs\Statistics\Projects;

use App\Jobs\Job;
use App\Models\Project;
use App\Models\Statistic;
use Carbon\Carbon;

abstract class IncreaseJob extends Job
{
    /**
     * @var Project
     */
    protected $project;

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
     * @param Project $project
     * @param int $delta
     * @param null|Carbon $date
     */
    public function __construct(Project $project, $delta = 1, Carbon $date = null)
    {
        $this->project = $project;
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
            ->project
            ->statistics()
            ->where('key', $this->statisticKey())
            ->where('date_at', $this->date->format('Y-m-d'))
            ->first();

        if ($existing) {
            $existing->update(['value' => $existing->value + $this->delta]);
        } else {
            $this
                ->project
                ->statistics()
                ->save(new Statistic([
                    'key' => $this->statisticKey(),
                    'value' => $this->delta,
                    'date_at' => $this->date,
                ]));
        }
    }
}
