<?php

namespace Plugins\TaxonomyCarousel\CreateLink;

use App\Contracts\TaxonomyCreateLink;
use App\Models\Bot;
use App\Models\Respond;

class CarouselLink implements TaxonomyCreateLink
{
    /**
     * Return title.
     *
     * @return string
     */
    public function title()
    {
        return 'Carousel';
    }

    /**
     * Return description.
     *
     * @return string
     */
    public function description()
    {
        return 'Send elements carousel as a response';
    }

    /**
     * Return icon HTML.
     *
     * @return string
     */
    public function icon()
    {
        return '<i class="fa fa-th-large"></i>';
    }

    /**
     * Return link.
     *
     * @param Bot $bot
     * @param Respond $respond
     * @return string
     */
    public function link(Bot $bot, Respond $respond)
    {
        return route('bots.responds.edit.taxonomies.create', [$bot->id, $respond->id, 'carousel']);
    }
}
