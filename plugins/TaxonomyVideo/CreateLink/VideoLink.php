<?php

namespace Plugins\TaxonomyVideo\CreateLink;

use App\Contracts\TaxonomyCreateLink;
use App\Models\Bot;
use App\Models\Respond;

class VideoLink implements TaxonomyCreateLink
{
    /**
     * Return title.
     *
     * @return string
     */
    public function title()
    {
        return 'Video';
    }

    /**
     * Return description.
     *
     * @return string
     */
    public function description()
    {
        return 'Send video to a recipient';
    }

    /**
     * Return icon HTML.
     *
     * @return string
     */
    public function icon()
    {
        return '<i class="fa fa-file-video-o"></i>';
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
        return route('bots.responds.edit.taxonomies.create', [$bot->id, $respond->id, 'video']);
    }
}
