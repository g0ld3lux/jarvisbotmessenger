<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Recipient;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecipientVariablePolicy
{
    use HandlesAuthorization;

    /**
     * @var array
     */
    protected $skipNames = ['first-name', 'last-name', 'gender', 'timezone', 'locale'];

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
     * @param Recipient\Variable $variable
     * @param Project $project
     * @return bool
     */
    protected function isVariableRelatedToProject(Recipient\Variable $variable, Project $project)
    {
        return $variable->project_id == $project->id;
    }

    /**
     * @param Recipient\Variable $variable
     * @return bool
     */
    protected function isSkipped(Recipient\Variable $variable)
    {
        return in_array($variable->accessor, $this->skipNames);
    }

    /**
     * @param User $user
     * @param Recipient\Variable $variable
     * @param Project $project
     * @return bool
     */
    public function edit(User $user, Recipient\Variable $variable, Project $project)
    {
        return $this->isProjectOwner($user, $project)
            && $this->isVariableRelatedToProject($variable, $project)
            && !$this->isSkipped($variable);
    }

    /**
     * @param User $user
     * @param Recipient\Variable $variable
     * @param Project $project
     * @return bool
     */
    public function delete(User $user, Recipient\Variable $variable, Project $project)
    {
        return $this->isProjectOwner($user, $project)
        && $this->isVariableRelatedToProject($variable, $project)
        && !$this->isSkipped($variable);
    }
}
