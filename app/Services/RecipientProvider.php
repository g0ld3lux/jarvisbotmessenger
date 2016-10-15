<?php

namespace App\Services;

use App\Jobs\Statistics\Projects\IncreaseRecipientsCount;
use App\Models\Project;
use App\Models\Recipient;
use Illuminate\Contracts\Bus\Dispatcher;

class RecipientProvider
{
    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * RecipientProvider constructor.
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Get recipient.
     *
     * @param Project $project
     * @param $reference
     * @return \App\Models\Recipient
     */
    public function get(Project $project, $reference)
    {
        try {
            return $this->find($project, $reference);
        } catch (\Exception $e) {
        }

        return $this->create($project, $reference);
    }

    /**
     * Find recipient.
     *
     * @param Project $project
     * @param $reference
     * @return \App\Models\Recipient
     */
    protected function find(Project $project, $reference)
    {
        return Recipient::where('project_id', $project->id)->where('reference', $reference)->firstOrFail();
    }

    /**
     * Create new recipient.
     *
     * @param Project $project
     * @param $reference
     * @return \App\Models\Recipient
     */
    protected function create(Project $project, $reference)
    {
        $recipient = new Recipient(['reference' => $reference]);
        $recipient->project()->associate($project);
        $recipient->save();

        $this->dispatcher->dispatch(new IncreaseRecipientsCount($project));

        return $recipient;
    }
}
