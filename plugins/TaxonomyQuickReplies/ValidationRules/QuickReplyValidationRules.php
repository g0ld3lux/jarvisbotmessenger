<?php

namespace Plugins\TaxonomyQuickReplies\ValidationRules;

use App\Contracts\TaxonomyValidationRules;

class QuickReplyValidationRules implements TaxonomyValidationRules
{
    /**
     * Return array of validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content_type' => 'required|in:text',
            'title' => 'required',
            'responds' => 'required',
        ];
    }
}
