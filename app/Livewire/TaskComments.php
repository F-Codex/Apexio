<?php

namespace App\Livewire;

use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Livewire\TaskList;

class TaskComments extends Component
{
    public Task $task;
    public $comments; 
    public string $newComment = '';

    protected function rules(): array
    {
        return [
            'newComment' => 'required|string|max:1000',
        ];
    }

    public function mount(Task $task): void
    {
        $this->task = $task;
        $this->loadComments();
    }

    public function saveComment(): void
    {
        $this->validate();
        $this->task->comments()->create([
            'user_id' => Auth::id(),
            'body' => $this->newComment,
        ]);
        $this->newComment = ''; 
        $this->reset('newComment');
        $this->loadComments();
        $this->dispatch('task-updated'); 
    }

    public function loadComments(): void
    {
        $this->comments = $this->task->comments()
                                  ->with('user')
                                  ->latest()
                                  ->get();
    }

    public function render(): View
    {
        return view('livewire.task-comments');
    }
}