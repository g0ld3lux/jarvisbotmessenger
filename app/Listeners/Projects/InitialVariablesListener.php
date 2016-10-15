<?php

namespace App\Listeners\Projects;

use App\Jobs\Projects\AddInitialVariables;
use App\Models\Project;
use App\Models\Recipient;
use Illuminate\Contracts\Bus\Dispatcher;

class InitialVariablesListener
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
        $this->dispatcher->dispatchNow(new AddInitialVariables($project));
    }
}
