<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if user is owner of a project.
     *
     * @param User $user
     * @param Project $project
     * @return bool
     */
    protected function isOwner(User $user, Project $project)
    {
        return $user->id == $project->user_id;
    }

    /**
     * Determine if user can update project settings.
     *
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function settings(User $user, Project $project)
    {
        return $this->isOwner($user, $project);
    }

    /**
     * Determine if user can delete project.
     *
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function delete(User $user, Project $project)
    {
        return $this->isOwner($user, $project);
    }

    /**
     * Determine if user can view project.
     *
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function view(User $user, Project $project)
    {
        return $this->isOwner($user, $project);
    }
}
