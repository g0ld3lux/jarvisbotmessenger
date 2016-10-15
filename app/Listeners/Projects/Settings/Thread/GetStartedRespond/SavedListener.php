<?php

namespace App\Listeners\Projects\Settings\Thread\GetStartedRespond;

use App\Jobs\Facebook\DeleteGetStartedRespondJob;
use App\Jobs\Facebook\SetGetStartedRespondJob;
use App\Models\Project\Settings\Thread;
use App\Models\Recipient;
use Illuminate\Contracts\Bus\Dispatcher;

class SavedListener
{
    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * InitialVariablesListener constructor.
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param Thread $thread
     */
    public function handle(Thread $thread)
    {
        if ($thread->isDirty('get_started_respond_id')) {
            if ($thread->getStartedRespond) {
                $this->dispatcher->dispatchNow(new SetGetStartedRespondJob(
                    $thread->project,
                    $thread->getStartedRespond
                ));
            } else {
                $this->dispatcher->dispatchNow(new DeleteGetStartedRespondJob($thread->project));
            }
        }
    }
}
