<?php

namespace App\Listeners\Bots;

use App\Jobs\Bots\AddInitialVariables;
use App\Models\Bot;
use App\Models\Recipient;
use Illuminate\Contracts\Bus\Dispatcher;

class InitialVariablesListener
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
        $this->dispatcher->dispatchNow(new AddInitialVariables($bot));
    }
}
