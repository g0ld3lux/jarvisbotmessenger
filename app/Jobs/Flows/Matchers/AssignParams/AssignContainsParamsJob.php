<?php

namespace App\Jobs\Flows\Matchers\AssignParams;

use App\Jobs\Job;
use App\Models\Flow\Matcher;
use App\Models\Respond\Taxonomy;
use Illuminate\Http\Request;

class AssignContainsParamsJob extends Job
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
     * @return void
     */
    public function handle()
    {
        if ($param = $this->matcher->params()->ofKey('text')->first()) {
            $param->value = $this->request->get('text');
            $param->save();
        } else {
            $param = new Matcher\Param(['key' => 'text', 'order' => 0, 'value' => $this->request->get('text')]);
            $param->matcher()->associate($this->matcher);
            $param->save();
        }

        if ($param = $this->matcher->params()->ofKey('case')->first()) {
            $param->value = $this->request->get('case');
            $param->save();
        } else {
            $param = new Matcher\Param(['key' => 'case', 'order' => 1, 'value' => $this->request->get('case')]);
            $param->matcher()->associate($this->matcher);
            $param->save();
        }
    }
}
