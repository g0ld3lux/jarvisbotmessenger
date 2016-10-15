<?php

namespace Plugins\TaxonomySaveInput\Executable;

use App\Models\Project;
use App\Models\Recipient;
use Bot\Core\Contract\Executable;
use Bot\Core\Respond\Flow;
use pimax\FbBotApp;
use Plugins\TaxonomySaveInput\Jobs\Executable\SaveInputJob;

class SaveInput implements Executable
{
    /**
     * @var string
     */
    protected $variable;

    /**
     * @param string $variable
     */
    public function __construct($variable)
    {
        $this->variable = $variable;
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
        return new SaveInputJob($this->variable, $text, $project, $recipient);
    }
}
