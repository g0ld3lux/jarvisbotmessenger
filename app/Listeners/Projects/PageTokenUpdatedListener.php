<?php

namespace App\Listeners\Projects;

use App\Jobs\Facebook\DeleteGetStartedRespondJob;
use App\Jobs\Facebook\DeletePersistentMenuRespondJob;
use App\Jobs\Facebook\SetGetStartedRespondJob;
use App\Jobs\Facebook\SetGreetingTextJob;
use App\Jobs\Facebook\SetPersistentMenuRespondJob;
use App\Models\Project;
use App\Models\Recipient;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Str;

class PageTokenUpdatedListener
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
     * @param Project $project
     */
    public function handle(Project $project)
    {
        if ($project->isDirty('page_token') && Str::length($project->page_token) > 0) {
            if ($project->threadSettings) {
                if (Str::length($project->threadSettings->greetingText) > 0) {
                    $this->dispatcher->dispatchNow(new SetGreetingTextJob(
                        $project,
                        $project->threadSettings->greeting_text
                    ));
                }

                if ($project->threadSettings->getStartedRespond) {
                    $this->dispatcher->dispatchNow(new SetGetStartedRespondJob(
                        $project,
                        $project->threadSettings->getStartedRespond
                    ));
                } else {
                    $this->dispatcher->dispatchNow(new DeleteGetStartedRespondJob($project));
                }

                if ($project->threadSettings->persistentMenuRespond) {
                    $this->dispatcher->dispatchNow(new SetPersistentMenuRespondJob(
                        $project,
                        $project->threadSettings->persistentMenuRespond
                    ));
                } else {
                    $this->dispatcher->dispatchNow(new DeletePersistentMenuRespondJob($project));
                }
            }
        }
    }
}
