<?php

namespace Bot\Core\Contract;

use App\Models\Project;
use App\Models\Recipient;
use Bot\Core\Respond\Flow;
use pimax\FbBotApp;

interface Executable
{
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
    public function job($type, $text, $flow, Project $project, Recipient $recipient, FbBotApp $botApp);
}
