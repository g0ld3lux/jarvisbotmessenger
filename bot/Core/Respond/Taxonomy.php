<?php

namespace Bot\Core\Respond;

use App\Models\Respond\Taxonomy as TaxonomyModel;

class Taxonomy
{
    /**
     * @var TaxonomyModel
     */
    protected $original;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var array
     */
    protected $attributes;

    /**
     * @var array
     */
    protected $children;

    /**
     * Respond constructor.
     * @param TaxonomyModel $original
     * @param string $type
     * @param array $attributes
     * @param array $children
     */
    public function __construct(TaxonomyModel $original, $type, $attributes = [], array $children = [])
    {
        $this->original = $original;
        $this->type = $type;
        $this->attributes = $attributes;
        $this->children = $children;
    }

    /**
     * @return TaxonomyModel
     */
    public function getOriginal()
    {
        return $this->original;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }
}
