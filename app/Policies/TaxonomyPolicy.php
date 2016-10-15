<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Respond;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaxonomyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if user is owner of a project.
     *
     * @param User $user
     * @param Project $project
     * @return bool
     */
    protected function isProjectOwner(User $user, Project $project)
    {
        return $user->id == $project->user_id;
    }

    /**
     * Determine is related to project.
     *
     * @param Respond $respond
     * @param Project $project
     * @return bool
     */
    protected function isRespondRelatedToProject(Respond $respond, Project $project)
    {
        return $respond->project_id == $project->id;
    }

    /**
     * Determine is related to project.
     *
     * @param Respond\Taxonomy $taxonomy
     * @param Respond $respond
     * @return bool
     */
    protected function isTaxonomyRelatedToRespond(Respond\Taxonomy $taxonomy, Respond $respond)
    {
        return $taxonomy->respond_id == $respond->id;
    }

    /**
     * Determine if user can edit.
     *
     * @param User $user
     * @param Respond\Taxonomy $taxonomy
     * @param Respond $respond
     * @param Project $project
     * @return bool
     */
    public function edit(User $user, Respond\Taxonomy $taxonomy, Respond $respond, Project $project)
    {
        return $this->isProjectOwner($user, $project)
            && $this->isRespondRelatedToProject($respond, $project)
            && $this->isTaxonomyRelatedToRespond($taxonomy, $respond);
    }

    /**
     * Determine if user can view.
     *
     * @param User $user
     * @param Respond\Taxonomy $taxonomy
     * @param Respond $respond
     * @param Project $project
     * @return bool
     */
    public function delete(User $user, Respond\Taxonomy $taxonomy, Respond $respond, Project $project)
    {
        return $this->isProjectOwner($user, $project)
            && $this->isRespondRelatedToProject($respond, $project)
            && $this->isTaxonomyRelatedToRespond($taxonomy, $respond);
    }
}
