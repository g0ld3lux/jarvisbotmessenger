<?php

namespace Bot\Core\Contract;

use App\Models\Bot;
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
     * @param Bot $bot
     * @param Recipient $recipient
     * @param FbBotApp $botApp
     * @return \Bot\Core\Jobs\Job
     */
    public function job($type, $text, $flow, Bot $bot, Recipient $recipient, FbBotApp $botApp);
}
