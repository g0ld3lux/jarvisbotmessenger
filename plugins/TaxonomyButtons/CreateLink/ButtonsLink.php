<?php

namespace Plugins\TaxonomyButtons\CreateLink;

use App\Contracts\TaxonomyCreateLink;
use App\Models\Project;
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
     * @param Project $project
     * @param Respond $respond
     * @return string
     */
    public function link(Project $project, Respond $respond)
    {
        return route('projects.responds.edit.taxonomies.create', [$project->id, $respond->id, 'buttons']);
    }
}
