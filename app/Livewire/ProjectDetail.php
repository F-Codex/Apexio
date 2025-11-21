<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;
use Livewire\Attributes\Layout; // Penting

class ProjectDetail extends Component
{
    public Project $project;

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    #[Layout('layouts.app-with-sidebar')] 
    public function render()
    {
        return view('livewire.project-detail');
    }
}