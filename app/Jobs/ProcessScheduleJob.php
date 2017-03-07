<?php

namespace App\Jobs;

use App\Events\ScheduleProcessedEvent;
use App\Models\Mass\Message\Schedule;
use App\Services\RespondMatcher;
use Bot\Core\Executor;
use Bot\FacebookMessenger\Bots;
use Bot\FacebookMessenger\Mapper;
use Carbon\Carbon;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessScheduleJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var array
     */
    protected $endpoints = [
        'status' => '/{reference}/feed',
        'link' => '/{reference}/feed',
        'photo' => '/{reference}/photos',
        'video' => '/{reference}/videos',
    ];

    /**
     * @var Schedule
     */
    protected $schedule;

    /**
     * @param Schedule $schedule
     */
    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * @param Dispatcher $dispatcher
     * @param RespondMatcher $matcher
     * @param Mapper $mapper
     * @param Bots $bots
     * @param Executor $executor
     */
    public function handle(
        Dispatcher $dispatcher,
        RespondMatcher $matcher,
        Mapper $mapper,
        Bots $bots,
        Executor $executor
    ) {
        try {
            $messages = [];

            foreach ($this->schedule->message->responds as $respond) {
                $messages = array_merge($messages, $mapper->mapRespond(
                    $matcher->respond($respond, $this->schedule->recipient),
                    $this->schedule->recipient->reference
                ));
            }

            foreach ($messages as $message) {
                $executor->execute(
                    'mass_message',
                    null,
                    null,
                    $this->schedule->message->bot,
                    $this->schedule->recipient,
                    $message,
                    $bots->get($this->schedule->message->bot->page_token)
                );
            }

            $this->schedule->sent_at = new Carbon();
            $this->schedule->finished_at = new Carbon();
            $this->schedule->save();

            $dispatcher->fire(new ScheduleProcessedEvent($this->schedule));
        } catch (\Exception $e) {
            $this->schedule->failed_at = new Carbon();
            $this->schedule->error = json_encode($e);
            $this->schedule->save();
            logger($e);
        }
    }
}
