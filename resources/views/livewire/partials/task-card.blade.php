<div class="card mb-3 shadow-sm">
    <div class="card-body">
        
        <div class="d-flex justify-content-between">
            <h6 class="card-title fw-bold">{{ $task->title }}</h6>
            
            @if($canDeleteTasks)
                <button class="btn btn-sm btn-outline-danger p-0" 
                        style="width: 20px; height: 20px; line-height: 0;"
                        wire:click="deleteTask({{ $task->id }})"
                        wire:confirm="Are you sure you want to delete this task?">
                    X
                </button>
            @endif
        </div>
        
        <p class="card-text small">{{ $task->description }}</p>
        
        @if ($task->assignee)
            <small class="text-muted d-block mb-2">
                Assigned to: <strong>{{ $task->assignee->name }}</strong>
            </small>
        @endif

        <select class="form-select form-select-sm" 
                wire:change="updateTaskStatus({{ $task->id }}, $event.target.value)">
            @foreach (App\Livewire\TaskList::STATUS_OPTIONS as $status)
                <option value="{{ $status }}" @if($task->status == $status) selected @endif>
                    {{ $status }}
                </option>
            @endforeach
        </select>
        
        <div class="mt-2">
            <a href="#" class="text-muted small" 
               wire:click.prevent="loadComments({{ $task->id }})"> 
               Comments ({{ $task->comments_count ?? 0 }})
            </a>
        </div>

    </div>
</div>