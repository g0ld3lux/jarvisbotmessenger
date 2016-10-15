<?php

namespace Plugins\TaxonomyPing\Jobs\Executable;

use App\Models\Project;
use App\Models\Recipient;
use Bot\Core\Jobs\Job;
use Bot\Core\Respond\Flow;
use GuzzleHttp\Client;

class PingJob extends Job
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var Flow|null
     */
    protected $flow;

    /**
     * @var Project
     */
    protected $project;

    /**
     * @var Recipient
     */
    protected $recipient;

    /**
     * PingJob constructor.
     * @param string $url
     * @param string $type
     * @param string $text
     * @param null|Flow $flow
     * @param Project $project
     * @param Recipient $recipient
     */
    public function __construct($url, $type, $text, $flow, Project $project, Recipient $recipient)
    {
        $this->url = $url;
        $this->type = $type;
        $this->text = $text;
        $this->flow = $flow;
        $this->project = $project;
        $this->recipient = $recipient;
    }

    /**
     * Send message.
     *
     * @return void
     */
    public function handle()
    {
        (new Client())->get($this->url, ['query' => $this->query()]);
    }

    /**
     * @return array
     */
    protected function query()
    {
        $query = [];

        $query['incoming'] = $this->queryIncoming();

        $query['project'] = $this->queryProject();

        $query['flow'] = $this->queryFlow();

        $query['recipient'] = $this->queryRecipient();

        return $query;
    }

    /**
     * @return array
     */
    protected function queryIncoming()
    {
        return ['type' => $this->type, 'text' => $this->text];
    }

    /**
     * @return array
     */
    protected function queryProject()
    {
        return ['id' => $this->project->id, 'title' => $this->project->title];
    }

    /**
     * @return array
     */
    protected function queryFlow()
    {
        return ['id' => $this->flow->getOriginal()->id, 'title' => $this->flow->getOriginal()->title];
    }

    /**
     * @return array
     */
    protected function queryRecipient()
    {
        $data = ['id' => $this->recipient->id];

        $recipientVariables = Recipient\Variable\Relation::with('variable', 'values')
            ->where('recipient_id', $this->recipient->id)
            ->get();

        foreach ($recipientVariables as $variable) {
            $data[$variable->variable->accessor] = $variable->getParamValue('text');
        }

        return $data;
    }
}
