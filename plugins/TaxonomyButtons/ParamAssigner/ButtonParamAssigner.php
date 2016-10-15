<?php

namespace Plugins\TaxonomyButtons\ParamAssigner;

use App\Jobs\Responds\Taxonomies\AssignParams\AbstractParamAssigner;
use App\Models\Respond\Taxonomy\Param;

class ButtonParamAssigner extends AbstractParamAssigner
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

        $title = $this->param('title');
        $title->value = $this->value('title');
        $title->order = 1;
        $title->save();

        switch ($option->value) {
            case 'web_url':
                $url = $this->param('url');
                $url->value = $this->value('url');
                $url->order = 2;
                $url->save();
                break;

            case 'postback':
                $this->taxonomy->params()->ofKey('respond')->delete();

                foreach ($this->request->get('responds', []) as $index => $respond) {
                    $param = new Param(['key' => 'respond', 'order' => $index + 2, 'value' => $respond]);
                    $param->taxonomy()->associate($this->taxonomy);
                    $param->save();
                }
                break;

            case 'phone_number':
                $url = $this->param('phone_number');
                $url->value = $this->value('phone_number');
                $url->order = 2;
                $url->save();
                break;
        }
    }
}
