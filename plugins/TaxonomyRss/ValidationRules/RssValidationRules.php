<?php

namespace Plugins\TaxonomyRss\ValidationRules;

use App\Contracts\TaxonomyValidationRules;

class RssValidationRules implements TaxonomyValidationRules
{
    /**
     * Return array of validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'url' => 'required|rss_feed',
            'count' => 'required|integer|min:1|max:9',
            'text_link' => 'required',
        ];
    }
}
