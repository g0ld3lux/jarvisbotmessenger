<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Respond;
use App\Models\Subscription\Channel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscriptionChannelPolicy
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
     * @param Channel $channel
     * @param Project $project
     * @return bool
     */
    protected function isChannelRelatedToProject(Channel $channel, Project $project)
    {
        return $channel->project_id == $project->id;
    }

    /**
     * @param User $user
     * @param Channel $channel
     * @param Project $project
     * @return bool
     */
    public function view(User $user, Channel $channel, Project $project)
    {
        return $this->isProjectOwner($user, $project) && $this->isChannelRelatedToProject($channel, $project);
    }

    /**
     * @param User $user
     * @param Channel $channel
     * @param Project $project
     * @return bool
     */
    public function edit(User $user, Channel $channel, Project $project)
    {
        return $this->isProjectOwner($user, $project) && $this->isChannelRelatedToProject($channel, $project);
    }

    /**
     * @param User $user
     * @param Channel $channel
     * @param Project $project
     * @return bool
     */
    public function delete(User $user, Channel $channel, Project $project)
    {
        return $this->isProjectOwner($user, $project) && $this->isChannelRelatedToProject($channel, $project);
    }
}
