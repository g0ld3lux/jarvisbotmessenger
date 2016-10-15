<?php

namespace App\Listeners\Projects\Settings\Thread\PersistentMenuRespond;

use App\Jobs\Facebook\DeletePersistentMenuRespondJob;
use App\Jobs\Facebook\SetPersistentMenuRespondJob;
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
        if ($thread->isDirty('persistent_menu_respond_id')) {
            if ($thread->persistentMenuRespond) {
                $this->dispatcher->dispatchNow(new SetPersistentMenuRespondJob(
                    $thread->project,
                    $thread->persistentMenuRespond
                ));
            } else {
                $this->dispatcher->dispatchNow(new DeletePersistentMenuRespondJob($thread->project));
            }
        }
    }
}
