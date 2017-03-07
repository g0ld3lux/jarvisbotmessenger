<?php

namespace App\Listeners\Bots;

use App\Models\Bot;
use App\Models\Recipient;
use Illuminate\Contracts\Bus\Dispatcher;

class BotCreatedListener
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
        $bot->threadSettings()->save(new Bot\Settings\Thread());
    }
}
