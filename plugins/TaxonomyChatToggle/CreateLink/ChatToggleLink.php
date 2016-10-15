<?php

namespace Plugins\TaxonomyChatToggle\CreateLink;

use App\Contracts\TaxonomyCreateLink;
use App\Models\Project;
use App\Models\Respond;

class ChatToggleLink implements TaxonomyCreateLink
{
    /**
     * Return title.
     *
     * @return string
     */
    public function title()
    {
        return 'Chat Toggle';
    }

    /**
     * Return description.
     *
     * @return string
     */
    public function description()
    {
        return 'Disable / enable chat for recipient';
    }

    /**
     * Return icon HTML.
     *
     * @return string
     */
    public function icon()
    {
        return '<i class="fa fa-toggle-on"></i>';
    }

    /**
     * Return link.
     *
     * @param Project $project
     * @param Respond $respond
     * @return string
     */
    public function link(Project $project, Respond $respond)
    {
        return route('projects.responds.edit.taxonomies.create', [$project->id, $respond->id, 'chat_toggle']);
    }
}
