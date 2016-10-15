<?php

namespace Plugins\TaxonomySubscribe\ParamAssigner;

use App\Jobs\Responds\Taxonomies\AssignParams\AbstractParamAssigner;

class SubscribeParamAssigner extends AbstractParamAssigner
{
    /**
     * Assign params.
     */
    public function handle()
    {
        $variable = $this->param('channel');
        $variable->value = $this->value('channel');
        $variable->order = 0;
        $variable->save();

        $option = $this->param('option');
        $option->value = $this->value('option');
        $option->order = 1;
        $option->save();
    }
}
