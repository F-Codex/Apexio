<?php

namespace App\Livewire;

use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ManageProjects extends Component
{
    public Collection $projects;
    public string $name = '';
    public ?string $description = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:65535',
    ];

    public function mount(): void
    {
        $this->loadProjects();
    }

    public function render(): View
    {
        return view('livewire.manage-projects');
    }

    public function openCreateModal(): void
    {
        $this->reset(['name', 'description']);
        $this->dispatch('open-create-modal'); 
    }

    public function saveProject(): void
    {
        $validatedData = $this->validate();
        $user = Auth::user();

        $project = $user->ownedProjects()->create($validatedData);

        // Make creator an admin automatically
        $user->projects()->attach($project->id, ['role' => 'Admin']);

        $this->loadProjects();
        $this->dispatch('close-create-modal');
    }

    public function deleteProject(Project $project): void
    {
        $this->authorize('delete', $project);

        $project->delete();
        $this->loadProjects();
    }

    private function loadProjects(): void
    {
        $this->projects = Auth::user()->projects()->latest()->get();
    }
}