<?php

namespace Plugins\TaxonomyQuickReplies\ParamAssigner;

use App\Jobs\Responds\Taxonomies\AssignParams\AbstractParamAssigner;

class QuickRepliesParamAssigner extends AbstractParamAssigner
{
    /**
     * Assign params.
     */
    public function handle()
    {
        $param = $this->param('text');
        $param->value = $this->value('text');
        $param->order = 0;
        $param->save();
    }
}
