<?php

namespace App\Jobs\Flows\Matchers;

use App\Jobs\Job;
use App\Models\Flow\Matcher;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AssignParamsJob extends Job
{
    /**
     * @var Matcher
     */
    protected $matcher;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @param Matcher $matcher
     * @param Request $request
     */
    public function __construct(Matcher $matcher, Request $request)
    {
        $this->matcher = $matcher;
        $this->request = $request;
    }

    /**
     * @param Dispatcher $dispatcher
     */
    public function handle(Dispatcher $dispatcher)
    {
        $class = 'App\Jobs\Flows\Matchers\AssignParams\Assign'.Str::studly($this->matcher->type).'ParamsJob';

        if (class_exists($class)) {
            $dispatcher->dispatchNow(new $class($this->matcher, $this->request));
        }
    }
}
