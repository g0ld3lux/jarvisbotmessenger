<?php

namespace App\Jobs\Responds\Taxonomies;

use App\Jobs\Job;
use App\Models\Respond\Taxonomy;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MoveUpJob extends Job
{
    /**
     * @var Taxonomy
     */
    protected $taxonomy;

    /**
     * @param Taxonomy $taxonomy
     */
    public function __construct(Taxonomy $taxonomy)
    {
        $this->taxonomy = $taxonomy;
    }

    public function handle()
    {
        $order = $this->taxonomy->order + 1;

        Taxonomy::where('respond_id', $this->taxonomy->respond_id)
            ->where('order', $order)
            ->where('parent_id', $this->taxonomy->parent_id)
            ->decrement('order');

        $this->taxonomy->order = $order;
        $this->taxonomy->save();
    }
}
