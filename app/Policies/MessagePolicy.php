<?php

namespace App\Policies;

use App\Models\Flow;
use App\Models\Mass\Message;
use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Project $project
     * @return bool
     */
    protected function isProjectOwner(User $user, Project $project)
    {
        return $user->id == $project->user_id;
    }

    /**
     * @param Message $message
     * @param Project $project
     * @return bool
     */
    protected function isMessageRelatedToProject(Message $message, Project $project)
    {
        return $message->project_id == $project->id;
    }

    /**
     * @param User $user
     * @param Message $message
     * @param Project $project
     * @return bool
     */
    public function view(User $user, Message $message, Project $project)
    {
        return $this->isProjectOwner($user, $project) && $this->isMessageRelatedToProject($message, $project);
    }

    /**
     * @param User $user
     * @param Message $message
     * @param Project $project
     * @return bool
     */
    public function delete(User $user, Message $message, Project $project)
    {
        return $this->isProjectOwner($user, $project)
            && $this->isMessageRelatedToProject($message, $project)
            && !$message->is_started
            && !$message->is_finished;
    }
}
