<?php

namespace App\Console\Commands\Messages\Schedules;

use App\Jobs\ProcessScheduleJob;
use App\Models\Mass\Message\Schedule;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\Dispatcher;

class Process extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'messages:schedules:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process scheduled messages.';

    /**
     * @param Dispatcher $dispatcher
     */
    public function handle(Dispatcher $dispatcher)
    {
        $bar = $this->output->createProgressBar();
        $bar->setFormat('debug');
        $bar->start();

        while ($schedule = $this->entry()) {
            $schedule->started_at = new Carbon();
            $schedule->save();
            $dispatcher->dispatch(new ProcessScheduleJob($schedule));
            $bar->advance();
        }

        $bar->finish();

        $this->info('Done');
    }

    /**
     * @return Schedule
     */
    protected function entry()
    {
        return Schedule::whereNull('sent_at')
            ->whereNull('paused_at')
            ->whereNull('started_at')
            ->where('scheduled_at', '<=', new Carbon())
            ->first();
    }
}
