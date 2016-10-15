<?php

namespace App\Jobs\Flows\Matchers\AssignParams;

use App\Jobs\Job;
use App\Models\Flow\Matcher;
use App\Models\Respond\Taxonomy;
use Illuminate\Http\Request;

class AssignRegexParamsJob extends Job
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
        if ($param = $this->matcher->params()->ofKey('pattern')->first()) {
            $param->value = $this->request->get('pattern');
            $param->save();
        } else {
            $param = new Matcher\Param(['key' => 'pattern', 'order' => 0, 'value' => $this->request->get('pattern')]);
            $param->matcher()->associate($this->matcher);
            $param->save();
        }
    }
}
