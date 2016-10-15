<?php

namespace Plugins\TaxonomyVideo\ParamAssigner;

use App\Jobs\Responds\Taxonomies\AssignParams\AbstractParamAssigner;

class VideoParamAssigner extends AbstractParamAssigner
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

        switch ($option->value) {
            case 'url':
                $url = $this->param('url');
                $url->value = $this->value('url');
                $url->order = 1;
                $url->save();
                break;
        }
    }
}
