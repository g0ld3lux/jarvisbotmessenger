<?php

namespace Plugins\TaxonomyChatToggle\Executable;

use App\Models\Project;
use App\Models\Recipient;
use Bot\Core\Contract\Executable;
use Bot\Core\Respond\Flow;
use pimax\FbBotApp;
use Plugins\TaxonomyChatToggle\Jobs\Executable\ChatToggleJob;

class ChatToggle implements Executable
{
    /**
     * @var string
     */
    protected $option;

    /**
     * @param string $option
     */
    public function __construct($option)
    {
        $this->option = $option;
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
        return new ChatToggleJob($this->option, $recipient);
    }

    /**
     * @return string
     */
    public function getOption()
    {
        return $this->option;
    }
}
