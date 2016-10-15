<?php

namespace App\Jobs\Responds\Taxonomies;

use App\Jobs\Job;
use App\Models\Respond;

class GetNextOrderJob extends Job
{
    /**
     * @var Respond
     */
    protected $respond;

    /**
     * @var null|int
     */
    protected $parent;

    /**
     * GetNextOrderJob constructor.
     * @param Respond $respond
     * @param null $parent
     */
    public function __construct(Respond $respond, $parent = null)
    {
        $this->respond = $respond;
        $this->parent = $parent;
    }

    /**
     * @return int
     */
    public function handle()
    {
        if (!is_null($this->parent)) {
            return $this->respond->taxonomies()->where('parent_id', $this->parent)->max('order') + 1;
        }

        return $this->respond->taxonomies()->ofRoot()->max('order') + 1;
    }
}
