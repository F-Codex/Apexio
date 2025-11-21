<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Task $task): bool
    {
        // Can view if user is a project member
        return $this->isProjectMember($user, $task);
    }

    // Note: create() takes Project instead of Task since task doesn't exist yet
    public function create(User $user, Project $project): bool
    {
        // Any project member can create tasks
        return $project->members()->where('user_id', $user->id)->exists();
    }

    public function update(User $user, Task $task): bool
    {
        // Any project member can update tasks (change status, etc)
        return $this->isProjectMember($user, $task);
    }

    public function delete(User $user, Task $task): bool
    {
        // Only project admins can delete tasks
        return $this->isProjectAdmin($user, $task);
    }

    public function restore(User $user, Task $task): bool
    {
        return false;
    }

    public function forceDelete(User $user, Task $task): bool
    {
        return false;
    }

    private function isProjectAdmin(User $user, Task $task): bool
    {
        return $task->project->members()
                       ->where('user_id', $user->id)
                       ->where('role', 'Admin')
                       ->exists();
    }

    private function isProjectMember(User $user, Task $task): bool
    {
        return $task->project->members()->where('user_id', $user->id)->exists();
    }
}