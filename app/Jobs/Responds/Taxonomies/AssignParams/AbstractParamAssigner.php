<?php

namespace App\Jobs\Responds\Taxonomies\AssignParams;

use App\Jobs\Job;
use App\Models\Respond\Taxonomy;
use Illuminate\Http\Request;

abstract class AbstractParamAssigner extends Job
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
     * @param $key
     * @return Taxonomy\Param
     */
    protected function param($key)
    {
        $param = $this->taxonomy->params()->ofKey($key)->first();

        if (!$param) {
            $param = new Taxonomy\Param(['key' => $key]);
            $param->taxonomy()->associate($this->taxonomy);
        }

        return $param;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    protected function value($key, $default = null)
    {
        return $this->request->get($key, $default);
    }
}
