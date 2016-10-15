<?php

namespace App\Listeners\Projects;

use App\Models\Project;
use App\Models\Recipient;
use Illuminate\Contracts\Bus\Dispatcher;

class ProjectCreatedListener
{
    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * InitialVariablesListener constructor.
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param Project $project
     */
    public function handle(Project $project)
    {
        $project->threadSettings()->save(new Project\Settings\Thread());
    }
}
