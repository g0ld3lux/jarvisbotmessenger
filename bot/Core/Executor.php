<?php

namespace Bot\Core;

use App\Models\Recipient;
use App\Models\Project;
use Bot\Core\Contract\Executable;
use Bot\Core\Respond\Flow;
use Illuminate\Contracts\Bus\Dispatcher;
use pimax\FbBotApp;

class Executor
{
    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param $type
     * @param $text
     * @param null|Flow $flow
     * @param Project $project
     * @param Recipient $recipient
     * @param Executable $executable
     * @param FbBotApp $botApp
     */
    public function execute(
        $type,
        $text,
        $flow,
        Project $project,
        Recipient $recipient,
        Executable $executable,
        FbBotApp $botApp
    ) {
        try {
            $this->dispatcher->dispatch($executable->job($type, $text, $flow, $project, $recipient, $botApp));
        } catch (\Exception $e) {
            logger($e);
        }
    }
}
