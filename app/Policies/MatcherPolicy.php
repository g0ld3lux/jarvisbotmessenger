<?php

namespace App\Policies;

use App\Models\Flow;
use App\Models\Project;
use App\Models\Respond;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MatcherPolicy
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
    protected function isFlowRelatedToProject(Flow $flow, Project $project)
    {
        return $flow->project_id == $project->id;
    }

    /**
     * Determine is related to project.
     *
     * @param Flow\Matcher $matcher
     * @param Flow $flow
     * @return bool
     */
    protected function isMatcherRelatedToFlow(Flow\Matcher $matcher, Flow $flow)
    {
        return $matcher->flow_id == $flow->id;
    }

    /**
     * Determine if user can edit.
     *
     * @param User $user
     * @param Flow\Matcher $matcher
     * @param Flow $flow
     * @param Project $project
     * @return bool
     */
    public function edit(User $user, Flow\Matcher $matcher, Flow $flow, Project $project)
    {
        return $this->isProjectOwner($user, $project)
            && $this->isFlowRelatedToProject($flow, $project)
            && $this->isMatcherRelatedToFlow($matcher, $flow);
    }

    /**
     * Determine if user can delete.
     *
     * @param User $user
     * @param Flow\Matcher $matcher
     * @param Flow $flow
     * @param Project $project
     * @return bool
     */
    public function delete(User $user, Flow\Matcher $matcher, Flow $flow, Project $project)
    {
        return $this->isProjectOwner($user, $project)
            && $this->isFlowRelatedToProject($flow, $project)
            && $this->isMatcherRelatedToFlow($matcher, $flow);
    }
}
