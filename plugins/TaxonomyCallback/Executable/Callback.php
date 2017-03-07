<?php

namespace Plugins\TaxonomyCallback\Executable;

use App\Models\Bot;
use App\Models\Recipient;
use Bot\Core\Contract\Executable;
use Bot\Core\Respond\Flow;
use pimax\FbBotApp;
use Plugins\TaxonomyCallback\Jobs\Executable\CallbackJob;

class Callback implements Executable
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

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
    public function job($type, $text, $flow, Bot $bot, Recipient $recipient, FbBotApp $botApp)
    {
        return new CallbackJob($this->url, $type, $text, $flow, $bot, $recipient, $botApp);
    }
}
