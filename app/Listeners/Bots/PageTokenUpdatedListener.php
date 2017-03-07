<?php

namespace App\Listeners\Bots;

use App\Jobs\Facebook\DeleteGetStartedRespondJob;
use App\Jobs\Facebook\DeletePersistentMenuRespondJob;
use App\Jobs\Facebook\SetGetStartedRespondJob;
use App\Jobs\Facebook\SetGreetingTextJob;
use App\Jobs\Facebook\SetPersistentMenuRespondJob;
use App\Models\Bot;
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
     * @param Bot $bot
     */
    public function handle(Bot $bot)
    {
        if ($bot->isDirty('page_token') && Str::length($bot->page_token) > 0) {
            if ($bot->threadSettings) {
                if (Str::length($bot->threadSettings->greetingText) > 0) {
                    $this->dispatcher->dispatchNow(new SetGreetingTextJob(
                        $bot,
                        $bot->threadSettings->greeting_text
                    ));
                }

                if ($bot->threadSettings->getStartedRespond) {
                    $this->dispatcher->dispatchNow(new SetGetStartedRespondJob(
                        $bot,
                        $bot->threadSettings->getStartedRespond
                    ));
                } else {
                    $this->dispatcher->dispatchNow(new DeleteGetStartedRespondJob($bot));
                }

                if ($bot->threadSettings->persistentMenuRespond) {
                    $this->dispatcher->dispatchNow(new SetPersistentMenuRespondJob(
                        $bot,
                        $bot->threadSettings->persistentMenuRespond
                    ));
                } else {
                    $this->dispatcher->dispatchNow(new DeletePersistentMenuRespondJob($bot));
                }
            }
        }
    }
}
