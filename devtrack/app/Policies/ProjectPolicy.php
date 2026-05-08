<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function before(User $user, $ability): bool|null
    {
        return null;
    }

    private function isLead(User $user, Project $project): bool
    {
        return $project->members()
            ->wherePivot('role', 'lead')
            ->where('user_id', $user->id)
            ->exists();
    }

    private function isMember(User $user, Project $project): bool
    {
        return $project->members()
            ->where('user_id', $user->id)
            ->exists();
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Project $project): bool
    {
        return $this->isMember($user, $project);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Project $project): bool
    {
        return $this->isLead($user, $project);
    }

    public function delete(User $user, Project $project): bool
    {
        return $this->isLead($user, $project);
    }

    public function restore(User $user, Project $project): bool
    {
        return $this->isLead($user, $project);
    }

    public function forceDelete(User $user, Project $project): bool
    {
        return $this->isLead($user, $project);
    }
}
