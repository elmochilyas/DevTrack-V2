<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Check if user can view any tasks in a project.
     * Project lead and members can view tasks.
     */
    public function viewAny(User $user, Project $project): bool
    {
        return $project->created_by == $user->id || 
               $project->members()->where('user_id', $user->id)->exists();
    }

    /**
     *Check if the user is the lead (creator) of the project.
     */
    private function isLead(User $user, Task $task): bool
    {
        return $task->project->created_by == $user->id;
    }

    /**
     * Check if the user is a member of the project team.
     */
    private function isMember(User $user, Task $task): bool
    {
        return $task->project->members()->where('user_id', $user->id)->exists();
    }

    /**
     * Check if the user is the developer assigned to this specific task.
     */
    private function isAssigned(User $user, Task $task): bool
    {
        return $task->assigned_to == $user->id;
    }

    /**
     * Determine whether the user can view the task.
     */
    public function view(User $user, Task $task): bool
    {
        return $this->isMember($user, $task) || $this->isLead($user, $task);
    }

    /**
     * Determine whether the user can create a task in a project.
     * Only the project lead can create tasks.
     */
    public function create(User $user, Project $project): bool
    {
        return $project->created_by == $user->id;
    }

    /**
     * Determine whether the user can perform a full update.
     * Only project lead can update tasks.
     */
    public function update(User $user, Task $task): bool
    {
        return $this->isLead($user, $task);
    }

    /**
     * Determine whether the user can update the status.
     * Project lead and assigned developer can update status.
     */
    public function updateStatus(User $user, Task $task): bool
    {
        return $this->isLead($user, $task) || $this->isAssigned($user, $task);
    }

    /**
     * Determine whether the user can delete the task.
     * Only project lead can delete tasks.
     */
    public function delete(User $user, Task $task): bool
    {
        return $this->isLead($user, $task);
    }

    /**
     * Determine whether the user can restore the task.
     */
    public function restore(User $user, Task $task): bool
    {
        return $this->isLead($user, $task);
    }

    /**
     * Permanent deletion is disabled.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return false;
    }
}