<?php

namespace Plugins\TaxonomyButtons\CreateLink;

use App\Contracts\TaxonomyCreateLink;
use App\Models\Bot;
use App\Models\Respond;

class ButtonsLink implements TaxonomyCreateLink
{
    /**
     * Return title.
     *
     * @return string
     */
    public function title()
    {
        return 'Buttons';
    }

    /**
     * Return description.
     *
     * @return string
     */
    public function description()
    {
        return 'Return text with buttons';
    }

    /**
     * Return icon HTML.
     *
     * @return string
     */
    public function icon()
    {
        return '<i class="fa fa-th-list"></i>';
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
        return route('bots.responds.edit.taxonomies.create', [$bot->id, $respond->id, 'buttons']);
    }
}
