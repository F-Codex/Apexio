<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TaskList extends Component
{
    public const STATUS_OPTIONS = ['To-Do', 'In-Progress', 'Done'];

    public Project $project;
    public Collection $members;
  
    // Form Properties
    public string $title = '';
    public ?string $description = null;
    public ?int $assignee_id = null;
    public string $priority = 'medium';
    public string $status = 'To-Do';

    public bool $canCreateTasks = false;
    public bool $canDeleteTasks = false;
    
    public ?Task $taskWithComments = null; 

    protected $listeners = [
        'task-updated' => '$refresh'
    ];

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assignee_id' => 'nullable|exists:users,id',
            'priority' => 'required|in:low,medium,high,critical',
            'status' => 'required|in:To-Do,In-Progress,Done',
        ];
    }

    public function mount(int $project_id): void
    {
        $this->project = Project::findOrFail($project_id);
        $this->members = $this->project->members()->get();

        $user = Auth::user();
        $this->canCreateTasks = $user->can('create', [Task::class, $this->project]);
        $this->canDeleteTasks = $user->can('update', $this->project);
    }

    public function render(): View
    {
        $allTasks = $this->project->tasks()
            ->with(['assignee'])
            ->withCount('comments')
            ->latest()
            ->get();

        return view('livewire.task-list', [
            'todoTasks' => $allTasks->where('status', 'To-Do'),
            'inProgressTasks' => $allTasks->where('status', 'In-Progress'),
            'doneTasks' => $allTasks->where('status', 'Done'),
        ]);
    }

    public function loadComments(int $taskId): void
    {
        $task = Task::findOrFail($taskId);
        $this->authorize('view', $task); 
        $this->taskWithComments = $task;
        $this->dispatch('open-modal', 'commentsModal');
    }

    public function closeCommentModal(): void
    {
        $this->dispatch('close-modal', 'commentsModal');
        $this->taskWithComments = null;
    }

    public function saveTask(): void
    {
        $this->authorize('create', [Task::class, $this->project]);
        
        $validatedData = $this->validate();

        $this->project->tasks()->create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'user_id' => $validatedData['assignee_id'],
            'priority' => $validatedData['priority'],
            'status' => $validatedData['status'],
            'assignee_id' => $validatedData['assignee_id']
        ]);

        $this->reset('title', 'description', 'assignee_id', 'priority', 'status');
        $this->priority = 'medium';
        $this->status = 'To-Do';
        
        $this->dispatch('close-create-modal'); 
    }

    public function updateTaskStatus(int $task_id, string $status): void
    {
        if (!in_array($status, self::STATUS_OPTIONS)) {
            return;
        }
        $task = Task::find($task_id);
        $this->authorize('update', $task);
        $task->status = $status;
        $task->save();
    }

    public function deleteTask(int $task_id): void
    {
        $task = Task::find($task_id);
        $this->authorize('delete', $task);
        $task->delete();
    }
}