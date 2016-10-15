<?php

namespace App\Contracts;

use App\Models\Project;
use App\Models\Respond;

interface TaxonomyCreateLink
{
    /**
     * Return title.
     *
     * @return string
     */
    public function title();

    /**
     * Return description.
     *
     * @return string
     */
    public function description();

    /**
     * Return icon HTML.
     *
     * @return string
     */
    public function icon();

    /**
     * Return link.
     *
     * @param Project $project
     * @param Respond $respond
     * @return string
     */
    public function link(Project $project, Respond $respond);
}
