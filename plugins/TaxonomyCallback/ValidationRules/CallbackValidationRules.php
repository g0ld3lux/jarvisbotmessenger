<?php

namespace Plugins\TaxonomyCallback\ValidationRules;

use App\Contracts\TaxonomyValidationRules;

class CallbackValidationRules implements TaxonomyValidationRules
{
    /**
     * Return array of validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'url' => 'required',
        ];
    }
}
