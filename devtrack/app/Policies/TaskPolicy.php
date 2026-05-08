<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;

class TaskPolicy
{
    private function isLead(User $user, Task $task): bool
    {
        return $task->project->members()
            ->wherePivot('role', 'lead')
            ->where('user_id', $user->id)
            ->exists();
    }

    private function isMember(User $user, Task $task): bool
    {
        return $task->project->members()
            ->where('user_id', $user->id)
            ->exists();
    }

    private function isAssigned(User $user, Task $task): bool
    {
        return $task->assigned_to == $user->id;
    }

    public function viewAny(User $user, Project $project): bool
    {
        return $project->members()
            ->where('user_id', $user->id)
            ->exists();
    }

    public function view(User $user, Task $task): bool
    {
        return $this->isMember($user, $task);
    }

    public function create(User $user, Project $project): bool
    {
        return $project->members()
            ->wherePivot('role', 'lead')
            ->where('user_id', $user->id)
            ->exists();
    }

    public function update(User $user, Task $task): bool
    {
        return $this->isLead($user, $task);
    }

    public function updateStatus(User $user, Task $task): bool
    {
        return $this->isLead($user, $task) || $this->isAssigned($user, $task);
    }

    public function delete(User $user, Task $task): bool
    {
        return $this->isLead($user, $task);
    }

    public function restore(User $user, Task $task): bool
    {
        return $this->isLead($user, $task);
    }

    public function forceDelete(User $user, Task $task): bool
    {
        return false;
    }
}
