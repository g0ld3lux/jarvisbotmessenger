<?php

namespace App\Services\Taxonomies;

class ParamAssignerRegistry
{
    /**
     * @var array
     */
    protected $assigners = [];

    /**
     * ParamAssignerRegistry constructor.
     * @param array $assigners
     */
    public function __construct(array $assigners = [])
    {
        $this->assigners = $assigners;
    }

    /**
     * @param $taxonomyType
     * @param $class
     */
    public function add($taxonomyType, $class)
    {
        if (isset($this->assigners[$taxonomyType])) {
            throw new \InvalidArgumentException('Assigner for "'.$taxonomyType.'" already exists!');
        }

        $this->assigners[$taxonomyType] = $class;
    }

    /**
     * @param $taxonomyType
     * @return mixed
     */
    public function assigner($taxonomyType)
    {
        if (!isset($this->assigners[$taxonomyType])) {
            throw new \InvalidArgumentException('Assigner for "'.$taxonomyType.'" does not exists!');
        }

        return $this->assigners[$taxonomyType];
    }
}
