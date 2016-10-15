<?php

namespace Plugins\TaxonomyPing\ValidationRules;

use App\Contracts\TaxonomyValidationRules;

class PingValidationRules implements TaxonomyValidationRules
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
