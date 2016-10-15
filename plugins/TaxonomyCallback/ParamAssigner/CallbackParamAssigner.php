<?php

namespace Plugins\TaxonomyCallback\ParamAssigner;

use App\Jobs\Responds\Taxonomies\AssignParams\AbstractParamAssigner;

class CallbackParamAssigner extends AbstractParamAssigner
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
    }
}
