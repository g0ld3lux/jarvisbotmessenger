<?php

namespace Plugins\TaxonomyPing\CreateLink;

use App\Contracts\TaxonomyCreateLink;
use App\Models\Bot;
use App\Models\Respond;

class PingLink implements TaxonomyCreateLink
{
    /**
     * Return title.
     *
     * @return string
     */
    public function title()
    {
        return 'Ping';
    }

    /**
     * Return description.
     *
     * @return string
     */
    public function description()
    {
        return 'Call (ping) given URL';
    }

    /**
     * Return icon HTML.
     *
     * @return string
     */
    public function icon()
    {
        return '<i class="fa fa-bullhorn"></i>';
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
        return route('bots.responds.edit.taxonomies.create', [$bot->id, $respond->id, 'ping']);
    }
}
