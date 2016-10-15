<?php

namespace Plugins\TaxonomyFile\ValidationRules;

use App\Contracts\TaxonomyValidationRules;

class FileValidationRules implements TaxonomyValidationRules
{
    /**
     * Return array of validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'option' => 'required|in:url,upload',
            'url' => 'required_if:option,url',
        ];
    }
}
