<?php

namespace Plugins\TaxonomySubscribe\Executable;

use App\Models\Bot;
use App\Models\Recipient;
use Bot\Core\Contract\Executable;
use Bot\Core\Respond\Flow;
use pimax\FbBotApp;
use Plugins\TaxonomySubscribe\Jobs\Executable\SubscribeJob;

class Subscribe implements Executable
{
    /**
     * @var string
     */
    protected $channel;

    /**
     * @var string
     */
    protected $option;

    /**
     * @param $channel
     * @param $option
     * @internal param string $variable
     */
    public function __construct($channel, $option)
    {
        $this->channel = $channel;
        $this->option = $option;
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
        return new SubscribeJob($this->channel, $this->option, $bot, $recipient);
    }
}
