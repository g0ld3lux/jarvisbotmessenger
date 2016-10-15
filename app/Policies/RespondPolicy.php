<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Respond;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RespondPolicy
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
     * Determine if user can view.
     *
     * @param User $user
     * @param Respond $respond
     * @param Project $project
     * @return bool
     */
    public function view(User $user, Respond $respond, Project $project)
    {
        return $this->isProjectOwner($user, $project) && $this->isRespondRelatedToProject($respond, $project);
    }

    /**
     * Determine if user can edit.
     *
     * @param User $user
     * @param Respond $respond
     * @param Project $project
     * @return bool
     */
    public function edit(User $user, Respond $respond, Project $project)
    {
        return $this->isProjectOwner($user, $project) && $this->isRespondRelatedToProject($respond, $project);
    }

    /**
     * Determine if user can view.
     *
     * @param User $user
     * @param Respond $respond
     * @param Project $project
     * @return bool
     */
    public function delete(User $user, Respond $respond, Project $project)
    {
        return $this->isProjectOwner($user, $project) && $this->isRespondRelatedToProject($respond, $project);
    }
}
