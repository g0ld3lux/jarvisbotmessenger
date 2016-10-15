<?php

namespace Bot\FacebookMessenger\Executable;

use App\Models\Project;
use App\Models\Recipient;
use Bot\Core\Contract\Executable;
use Bot\Core\Respond\Flow;
use Bot\FacebookMessenger\Jobs\Executable\SendMessageJob;
use pimax\FbBotApp;

class Message implements Executable
{
    /**
     * @var mixed
     */
    protected $message;

    /**
     * Message constructor.
     * @param mixed $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Return job.
     *
     * @param $type
     * @param $text
     * @param null|Flow $flow
     * @param Project $project
     * @param Recipient $recipient
     * @param FbBotApp $botApp
     * @return \Bot\Core\Jobs\Job
     */
    public function job($type, $text, $flow, Project $project, Recipient $recipient, FbBotApp $botApp)
    {
        return new SendMessageJob($this->message, $botApp);
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }
}
