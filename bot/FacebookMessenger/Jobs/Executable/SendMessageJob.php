<?php

namespace Bot\FacebookMessenger\Jobs\Executable;

use Bot\Core\Jobs\Job;
use pimax\FbBotApp;

class SendMessageJob extends Job
{
    /**
     * @var mixed
     */
    protected $message;

    /**
     * @var FbBotApp
     */
    protected $botApp;

    /**
     * SendMessageJob constructor.
     * @param mixed $message
     * @param FbBotApp $botApp
     */
    public function __construct($message, FbBotApp $botApp)
    {
        $this->message = $message;
        $this->botApp = $botApp;
    }

    /**
     * Send message.
     *
     * @return void
     */
    public function handle()
    {
        $this->botApp->send($this->message);
    }
}
