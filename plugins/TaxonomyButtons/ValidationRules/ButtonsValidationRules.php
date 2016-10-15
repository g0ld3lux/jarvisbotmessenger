<?php

namespace Plugins\TaxonomyButtons\ValidationRules;

use App\Contracts\TaxonomyValidationRules;

class ButtonsValidationRules implements TaxonomyValidationRules
{
    /**
     * Return array of validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'text' => 'required'
        ];
    }
}
