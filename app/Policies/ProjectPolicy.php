<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Project $project): bool
    {
        // Can view if user is a member
        return $project->members()->where('user_id', $user->id)->exists();
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Project $project): bool
    {
        // Only admins can update project settings and manage members
        return $this->isProjectAdmin($user, $project);
    }

    public function delete(User $user, Project $project): bool
    {
        // Only admins can delete projects
        return $this->isProjectAdmin($user, $project);
    }

    public function restore(User $user, Project $project): bool
    {
        return false;
    }

    public function forceDelete(User $user, Project $project): bool
    {
        return false;
    }

    private function isProjectAdmin(User $user, Project $project): bool
    {
        return $project->members()
                       ->where('user_id', $user->id)
                       ->where('role', 'Admin')
                       ->exists();
    }
}