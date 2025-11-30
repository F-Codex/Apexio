<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class AdminDashboard extends Component
{
    use WithPagination;

    public $search = '';

    #[Layout('layouts.app-with-sidebar')] 
    public function mount()
    {
        // Enforce strict admin access
        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function resetPassword($userId)
    {
        $user = User::findOrFail($userId);
        
        $user->password = Hash::make('password123');
        $user->save();

        $this->dispatch('alert', type: 'success', message: "Password reset for {$user->name}");
    }

    public function toggleAdmin($userId)
    {
        if ($userId === Auth::id()) return;

        $user = User::findOrFail($userId);
        $user->is_admin = !$user->is_admin;
        $user->save();
        
        $role = $user->is_admin ? 'Admin' : 'User';
        $this->dispatch('alert', type: 'info', message: "User promoted to {$role}");
    }

    public function deleteUser($userId)
    {
        if ($userId === Auth::id()) return;
        
        User::findOrFail($userId)->delete();
        $this->dispatch('alert', type: 'error', message: "User deleted successfully");
    }

    public function render()
    {
        $users = User::query()
            ->where('name', 'like', '%'.$this->search.'%')
            ->orWhere('email', 'like', '%'.$this->search.'%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin-dashboard', [
            'stats' => [
                'users' => User::count(),
                'projects' => Project::count(),
                'tasks' => Task::count(),
                'active_tasks' => Task::where('status', '!=', 'Done')->count(),
            ],
            'users' => $users
        ]);
    }
}