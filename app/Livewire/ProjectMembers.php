<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProjectMembers extends Component
{
    public Project $project;
    public Collection $members;
    public string $email = '';
    public bool $canManageMembers = false;

    protected function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
        ];
    }

    protected function messages(): array
    {
        return [
            'email.exists' => 'User with that email not found.',
        ];
    }

    public function mount(Project $project): void
    {
        $this->project = $project;
        $this->loadMembers();

        $this->canManageMembers = Auth::user()->can('update', $this->project);
    }

    public function render(): View
    {
        return view('livewire.project-members');
    }

    public function addMember(): void
    {
        $this->authorize('update', $this->project);

        $validatedData = $this->validate();
        $userToAdd = User::where('email', $validatedData['email'])->first();

        // Check if already a member
        if ($this->project->members()->where('user_id', $userToAdd->id)->exists()) {
            $this->addError('email', 'This user is already a member.');
            return;
        }

        $this->project->members()->attach($userToAdd->id, ['role' => 'Member']);

        $this->loadMembers();
        $this->reset('email');
    }

    private function loadMembers(): void
    {
        $this->members = $this->project->members()->withPivot('role')->get();
    }
}