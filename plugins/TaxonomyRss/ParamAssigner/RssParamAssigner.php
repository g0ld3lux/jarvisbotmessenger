<?php

namespace Plugins\TaxonomyRss\ParamAssigner;

use App\Jobs\Responds\Taxonomies\AssignParams\AbstractParamAssigner;

class RssParamAssigner extends AbstractParamAssigner
{
    /**
     * Assign params.
     */
    public function handle()
    {
        $url = $this->param('url');
        $url->value = $this->value('url');
        $url->order = 0;
        $url->save();

        $count = $this->param('count');
        $count->value = $this->value('count');
        $count->order = 1;
        $count->save();

        $textLink = $this->param('text_link');
        $textLink->value = $this->value('text_link');
        $textLink->order = 2;
        $textLink->save();
    }
}
