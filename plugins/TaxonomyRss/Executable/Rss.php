<?php

namespace Plugins\TaxonomyRss\Executable;

use App\Models\Project;
use App\Models\Recipient;
use Bot\Core\Contract\Executable;
use Bot\Core\Respond\Flow;
use pimax\FbBotApp;
use Plugins\TaxonomyRss\Jobs\Executable\RssJob;

class Rss implements Executable
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var int
     */
    protected $count;

    /**
     * @var string
     */
    protected $textLink;

    /**
     * @param string $url
     * @param $count
     * @param $textLink
     */
    public function __construct($url, $count, $textLink)
    {
        $this->url = $url;
        $this->count = $count;
        $this->textLink = $textLink;
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
        return new RssJob($this->url, $this->count, $this->textLink, $recipient, $botApp);
    }
}
