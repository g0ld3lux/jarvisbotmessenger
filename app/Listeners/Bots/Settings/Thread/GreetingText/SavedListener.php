<?php

namespace App\Listeners\Bots\Settings\Thread\GreetingText;

use App\Jobs\Facebook\SetGreetingTextJob;
use App\Models\Bot\Settings\Thread;
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
        if ($thread->isDirty('greeting_text')) {
            $this->dispatcher->dispatchNow(new SetGreetingTextJob($thread->bot, $thread->greeting_text));
        }
    }
}
