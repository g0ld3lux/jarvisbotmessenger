<?php

namespace Plugins\TaxonomyQuickReplies\CreateLink;

use App\Contracts\TaxonomyCreateLink;
use App\Models\Project;
use App\Models\Respond;

class QuickRepliesLink implements TaxonomyCreateLink
{
    /**
     * Return title.
     *
     * @return string
     */
    public function title()
    {
        return 'Quick Replies';
    }

    /**
     * Return description.
     *
     * @return string
     */
    public function description()
    {
        return 'Send quick replies as a response';
    }

    /**
     * Return icon HTML.
     *
     * @return string
     */
    public function icon()
    {
        return '<i class="fa fa-reply"></i>';
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
        return route('projects.responds.edit.taxonomies.create', [$project->id, $respond->id, 'quick_replies']);
    }
}
