<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Recipient;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecipientPolicy
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
     * @param Recipient $recipient
     * @param Project $project
     * @return bool
     */
    protected function isRecipientRelatedToProject(Recipient $recipient, Project $project)
    {
        return $recipient->project_id == $project->id;
    }

    /**
     * Determine if user can view.
     *
     * @param User $user
     * @param Recipient $recipient
     * @param Project $project
     * @return bool
     */
    public function view(User $user, Recipient $recipient, Project $project)
    {
        return $this->isProjectOwner($user, $project) && $this->isRecipientRelatedToProject($recipient, $project);
    }

    /**
     * @param User $user
     * @param Recipient $recipient
     * @param Project $project
     * @return bool
     */
    public function edit(User $user, Recipient $recipient, Project $project)
    {
        return $this->isProjectOwner($user, $project) && $this->isRecipientRelatedToProject($recipient, $project);
    }
}
