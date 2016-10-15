<?php

namespace Plugins\TaxonomyCarousel\ValidationRules;

use App\Contracts\TaxonomyValidationRules;

class ElementValidationRules implements TaxonomyValidationRules
{
    /**
     * Return array of validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'sub_title' => '',
            'image_url' => 'required',
        ];
    }
}
