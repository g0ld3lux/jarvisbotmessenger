<?php

namespace Plugins\TaxonomyChatToggle\ParamAssigner;

use App\Jobs\Responds\Taxonomies\AssignParams\AbstractParamAssigner;

class ChatToggleParamAssigner extends AbstractParamAssigner
{
    /**
     * Assign params.
     */
    public function handle()
    {
        $option = $this->param('option');
        $option->value = $this->value('option');
        $option->order = 0;
        $option->save();
    }
}
