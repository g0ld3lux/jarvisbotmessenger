<?php

namespace Plugins\TaxonomyCallback\CreateLink;

use App\Contracts\TaxonomyCreateLink;
use App\Models\Bot;
use App\Models\Respond;

class CallbackLink implements TaxonomyCreateLink
{
    /**
     * Return title.
     *
     * @return string
     */
    public function title()
    {
        return 'Callback';
    }

    /**
     * Return description.
     *
     * @return string
     */
    public function description()
    {
        return 'Send response from an API callback';
    }

    /**
     * Return icon HTML.
     *
     * @return string
     */
    public function icon()
    {
        return '<i class="fa fa-refresh"></i>';
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
        return route('bots.responds.edit.taxonomies.create', [$bot->id, $respond->id, 'callback']);
    }
}
