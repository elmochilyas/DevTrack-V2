<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    public function before(User $user, $ability): bool|null
    {
        // Admins bypass all checks (if you add admin role later)
        // if ($user->is_admin) {
        //     return true;
        // }

        // For now, return null (means "let the specific method decide")
        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Project $project): bool
    {
        if ($this->isLead($user, $project)) {
            return true;
        }

        return $this->isMember($user, $project);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        return $this->isLead($user, $project);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        return $this->isLead($user, $project);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Project $project): bool
    {
        return $this->isLead($user, $project);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Project $project): bool
    {
        return $this->isLead($user, $project);
    }

    private function isLead(User $user, Project $project): bool
    {
        return $project->created_by === $user->id;
    }

    private function isMember(User $user, Project $project): bool
    {
        return $project->members()->where('user_id', $user->id)->exists();
    }
}
