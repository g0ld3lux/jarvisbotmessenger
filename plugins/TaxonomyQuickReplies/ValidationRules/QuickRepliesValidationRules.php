<?php

namespace Plugins\TaxonomyQuickReplies\ValidationRules;

use App\Contracts\TaxonomyValidationRules;

class QuickRepliesValidationRules implements TaxonomyValidationRules
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
