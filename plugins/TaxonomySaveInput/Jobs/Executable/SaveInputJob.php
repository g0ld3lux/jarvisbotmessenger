<?php

namespace Plugins\TaxonomySaveInput\Jobs\Executable;

use App\Jobs\Recipients\AssignVariablesJob;
use App\Models\Bot;
use App\Models\Recipient;
use Bot\Core\Jobs\Job;
use Illuminate\Contracts\Bus\Dispatcher;

class SaveInputJob extends Job
{
    /**
     * @var string
     */
    protected $variable;

    /**
     * @var int
     */
    protected $text;

    /**
     * @var string
     */
    protected $bot;

    /**
     * @var Recipient
     */
    protected $recipient;

    /**
     * SaveInputJob constructor.
     * @param string $variable
     * @param string $text
     * @param Bot $bot
     * @param Recipient $recipient
     */
    public function __construct($variable, $text, Bot $bot, Recipient $recipient)
    {
        $this->variable = $variable;
        $this->text = $text;
        $this->bot = $bot;
        $this->recipient = $recipient;
    }

    /**
     * @param Dispatcher $dispatcher
     */
    public function handle(Dispatcher $dispatcher)
    {
        $variable = $this->bot->recipientsVariables()->findOrFail($this->variable);

        $dispatcher->dispatchNow(new AssignVariablesJob($this->recipient, [$variable->accessor => $this->text]));
    }
}
