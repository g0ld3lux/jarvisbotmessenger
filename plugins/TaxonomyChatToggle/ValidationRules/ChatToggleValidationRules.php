<?php

namespace Plugins\TaxonomyChatToggle\ValidationRules;

use App\Contracts\TaxonomyValidationRules;

class ChatToggleValidationRules implements TaxonomyValidationRules
{
    /**
     * Return array of validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'option' => 'required|in:enable,disable',
        ];
    }
}
