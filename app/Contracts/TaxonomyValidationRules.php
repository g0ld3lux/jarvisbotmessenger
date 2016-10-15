<?php

namespace App\Contracts;

interface TaxonomyValidationRules
{
    /**
     * Return array of validation rules.
     *
     * @return array
     */
    public function rules();
}
