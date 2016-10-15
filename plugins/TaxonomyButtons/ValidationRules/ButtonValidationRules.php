<?php

namespace Plugins\TaxonomyButtons\ValidationRules;

use App\Contracts\TaxonomyValidationRules;

class ButtonValidationRules implements TaxonomyValidationRules
{
    /**
     * Return array of validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'option' => 'required|in:web_url,postback,phone_number',
            'title' => 'required',
            'url' => 'required_if:option,web_url',
            'responds' => 'required_if:option,postback',
            'phone_number' => 'required_if:option,phone_number',
        ];
    }
}
