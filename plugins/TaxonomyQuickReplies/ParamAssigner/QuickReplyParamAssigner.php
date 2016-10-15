<?php

namespace Plugins\TaxonomyQuickReplies\ParamAssigner;

use App\Jobs\Responds\Taxonomies\AssignParams\AbstractParamAssigner;
use App\Models\Respond\Taxonomy\Param;

class QuickReplyParamAssigner extends AbstractParamAssigner
{
    /**
     * Assign params.
     */
    public function handle()
    {
        $title = $this->param('content_type');
        $title->value = $this->value('content_type');
        $title->order = 0;
        $title->save();

        $title = $this->param('title');
        $title->value = $this->value('title');
        $title->order = 1;
        $title->save();

        $this->taxonomy->params()->ofKey('respond')->delete();

        foreach ($this->request->get('responds', []) as $index => $respond) {
            $param = new Param(['key' => 'respond', 'order' => $index + 2, 'value' => $respond]);
            $param->taxonomy()->associate($this->taxonomy);
            $param->save();
        }
    }
}
