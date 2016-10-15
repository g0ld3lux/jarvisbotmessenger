<?php

namespace Bot\Core\Respond;

use App\Models\Respond as RespondModel;

class Respond
{
    /**
     * @var RespondModel
     */
    protected $original;

    /**
     * @var array
     */
    protected $taxonomies;

    /**
     * Respond constructor.
     * @param \App\Models\Respond $original
     * @param array $taxonomies
     */
    public function __construct(RespondModel $original, $taxonomies = [])
    {
        $this->original = $original;
        $this->taxonomies = $taxonomies;
    }

    /**
     * @return RespondModel
     */
    public function getOriginal()
    {
        return $this->original;
    }


    /**
     * @return array
     */
    public function getTaxonomies()
    {
        return $this->taxonomies;
    }
}
