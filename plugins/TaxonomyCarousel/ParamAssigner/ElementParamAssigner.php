<?php

namespace Plugins\TaxonomyCarousel\ParamAssigner;

use App\Jobs\Responds\Taxonomies\AssignParams\AbstractParamAssigner;

class ElementParamAssigner extends AbstractParamAssigner
{
    /**
     * Assign params.
     */
    public function handle()
    {
        $title = $this->param('title');
        $title->value = $this->value('title');
        $title->order = 0;
        $title->save();

        $subTitle = $this->param('sub_title');
        $subTitle->value = $this->value('sub_title');
        $subTitle->order = 1;
        $subTitle->save();

        $imageUrl = $this->param('image_url');
        $imageUrl->value = $this->value('image_url');
        $imageUrl->order = 2;
        $imageUrl->save();
    }
}
