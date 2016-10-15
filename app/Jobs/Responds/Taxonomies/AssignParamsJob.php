<?php

namespace App\Jobs\Responds\Taxonomies;

use App\Jobs\Job;
use App\Models\Respond\Taxonomy;
use App\Services\Taxonomies\ParamAssignerRegistry;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\Request;

class AssignParamsJob extends Job
{
    /**
     * @var Taxonomy
     */
    protected $taxonomy;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @param Taxonomy $taxonomy
     * @param Request $request
     */
    public function __construct(Taxonomy $taxonomy, Request $request)
    {
        $this->taxonomy = $taxonomy;
        $this->request = $request;
    }

    /**
     * @param Dispatcher $dispatcher
     * @param ParamAssignerRegistry $registry
     */
    public function handle(Dispatcher $dispatcher, ParamAssignerRegistry $registry)
    {
        $class = $registry->assigner($this->taxonomy->type);

        $dispatcher->dispatchNow(new $class($this->taxonomy, $this->request));
    }
}
