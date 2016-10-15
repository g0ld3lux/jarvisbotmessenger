<?php

namespace Plugins\TaxonomyText\ParamAssigner;

use App\Jobs\Responds\Taxonomies\AssignParams\AbstractParamAssigner;

class TextParamAssigner extends AbstractParamAssigner
{
    /**
     * Assign params.
     */
    public function handle()
    {
        $text = $this->param('text');
        $text->value = $this->value('text');
        $text->order = 0;
        $text->save();
    }
}
