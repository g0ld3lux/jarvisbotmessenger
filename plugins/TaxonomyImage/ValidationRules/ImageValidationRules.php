<?php

namespace Plugins\TaxonomyImage\ValidationRules;

use App\Contracts\TaxonomyValidationRules;

class ImageValidationRules implements TaxonomyValidationRules
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
            'file' => 'required_if:option,upload|mimes:jpeg,png',
        ];
    }
}
