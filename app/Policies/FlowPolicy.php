<?php

namespace App\Policies;

use App\Models\Flow;
use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FlowPolicy
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
     * @param Flow $flow
     * @param Project $project
     * @return bool
     */
    protected function iFlowRelatedToProject(Flow $flow, Project $project)
    {
        return $flow->project_id == $project->id;
    }

    /**
     * Determine if user can view.
     *
     * @param User $user
     * @param Flow $flow
     * @param Project $project
     * @return bool
     */
    public function view(User $user, Flow $flow, Project $project)
    {
        return $this->isProjectOwner($user, $project) && $this->iFlowRelatedToProject($flow, $project);
    }

    /**
     * Determine if user can edit.
     *
     * @param User $user
     * @param Flow $flow
     * @param Project $project
     * @return bool
     */
    public function edit(User $user, Flow $flow, Project $project)
    {
        return $this->isProjectOwner($user, $project) && $this->iFlowRelatedToProject($flow, $project);
    }

    /**
     * Determine if user can view.
     *
     * @param User $user
     * @param Flow $flow
     * @param Project $project
     * @return bool
     */
    public function delete(User $user, Flow $flow, Project $project)
    {
        return $this->isProjectOwner($user, $project) && $this->iFlowRelatedToProject($flow, $project);
    }
}
