<?php

namespace App\Services\Taxonomies;

use App\Contracts\TaxonomyValidationRules;

class ValidationRulesRegistry
{
    /**
     * @var array
     */
    protected $rules = [];

    /**
     * @param array $rules
     */
    public function __construct(array $rules = [])
    {
        $this->rules = $rules;
    }

    /**
     * @param $taxonomyType
     * @param string $class
     */
    public function add($taxonomyType, $class)
    {
        if (isset($this->rules[$taxonomyType])) {
            throw new \InvalidArgumentException('Rules for "'.$taxonomyType.'" already exists!');
        }

        $this->rules[$taxonomyType] = $class;
    }

    /**
     * @param $taxonomyType
     * @return string
     */
    public function rules($taxonomyType)
    {
        if (!isset($this->rules[$taxonomyType])) {
            throw new \InvalidArgumentException('Rules for "'.$taxonomyType.'" does not exists!');
        }

        return $this->rules[$taxonomyType];
    }
}
