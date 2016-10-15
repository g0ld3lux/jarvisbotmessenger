<?php

namespace Plugins\TaxonomyText\ValidationRules;

use App\Contracts\TaxonomyValidationRules;

class TextValidationRules implements TaxonomyValidationRules
{
    /**
     * Return array of validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'text' => 'required',
        ];
    }
}
