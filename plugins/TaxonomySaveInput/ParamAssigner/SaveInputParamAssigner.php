<?php

namespace Plugins\TaxonomySaveInput\ParamAssigner;

use App\Jobs\Responds\Taxonomies\AssignParams\AbstractParamAssigner;

class SaveInputParamAssigner extends AbstractParamAssigner
{
    /**
     * Assign params.
     */
    public function handle()
    {
        $variable = $this->param('variable');
        $variable->value = $this->value('variable');
        $variable->order = 0;
        $variable->save();
    }
}
