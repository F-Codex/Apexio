<div class="h-100 d-flex flex-column">
    <div class="d-flex gap-4 h-100 w-100 overflow-x-auto pb-4 px-2" style="scroll-behavior: smooth;"> 
        @foreach([
            ['id' => 'todo', 'title' => 'To Do', 'tasks' => $todoTasks],
            ['id' => 'inprogress', 'title' => 'In Progress', 'tasks' => $inProgressTasks],
            ['id' => 'done', 'title' => 'Done', 'tasks' => $doneTasks]
        ] as $col)
        
        <div class="d-flex flex-column h-100 flex-fill" style="min-width: 300px;">
            {{-- Column Header --}}
            <div class="d-flex align-items-center justify-content-between mb-3 px-1">
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-bold text-dark" style="font-size: 0.95rem;">{{ $col['title'] }}</span>
                    <span class="text-muted bg-light border rounded px-2 py-0 small" style="font-size: 0.75rem;">{{ $col['tasks']->count() }}</span>
                </div>
            </div>

            {{-- Task List --}}
            <div class="d-flex flex-column gap-2 pb-5" style="min-height: 100px;">
                @forelse ($col['tasks'] as $task)
                    <div class="card border border-light shadow-sm task-card-hover position-relative" 
                         style="border-radius: 8px; cursor: pointer; transition: all 0.2s;"
                         wire:click="loadComments({{ $task->id }})">
                        
                        <div class="card-body p-3">
                            <div class="d-flex align-items-start gap-3 mb-2">
                                {{-- Check Circle --}}
                                <div class="check-circle flex-shrink-0 mt-1" 
                                     style="width: 18px; height: 18px; border: 1px solid #d1d5db; border-radius: 50%; display: flex; align-items: center; justify-content: center; z-index: 2;"
                                     wire:click.stop="updateTaskStatus({{ $task->id }}, 'Done')">
                                     @if($col['id'] == 'done')
                                        <div class="bg-success rounded-circle" style="width: 10px; height: 10px;"></div>
                                     @endif
                                </div>
                                
                                <div class="flex-grow-1">
                                    {{-- Title --}}
                                    <h6 class="mb-1 fw-medium text-dark {{ $col['id'] == 'done' ? 'text-decoration-line-through text-muted' : '' }}" style="font-size: 0.95rem; line-height: 1.4;">
                                        {{ $task->title }}
                                    </h6>

                                    {{-- Badges --}}
                                    <div class="asana-pill-container">
                                        {{-- Priority --}}
                                        @php
                                            $prioValue = $task->priority ?? 'medium';
                                            $prioClass = match($prioValue) {
                                                'critical' => 'priority-critical',
                                                'high'     => 'priority-high',
                                                'medium'   => 'priority-medium',
                                                'low'      => 'priority-low',
                                                default    => 'priority-low'
                                            };
                                        @endphp
                                        <span class="asana-pill {{ $prioClass }}">
                                            @if($prioValue === 'critical') 🔥 @endif {{ ucfirst($prioValue) }}
                                        </span>

                                        {{-- Status --}}
                                        @php
                                            $statusLabel = match($task->status) {
                                                'To-Do'       => 'Not Started',
                                                'In-Progress' => 'In Progress',
                                                'Done'        => 'Done',
                                                default       => $task->status
                                            };
                                            
                                            $statusClass = match($task->status) {
                                                'To-Do'       => 'status-not-started',
                                                'In-Progress' => 'status-in-progress',
                                                'Done'        => 'status-done',
                                                default       => 'status-not-started'
                                            };
                                        @endphp
                                        <span class="asana-pill {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Delete --}}
                                @if($canDeleteTasks)
                                <div class="position-absolute top-0 end-0 p-2" style="z-index: 2;">
                                    <button class="btn btn-link text-muted p-0 opacity-25 hover-opacity-100" 
                                            wire:click.stop="deleteTask({{ $task->id }})" wire:confirm="Delete this task?">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                                @endif
                            </div>

                            {{-- Card Footer --}}
                            <div class="d-flex align-items-center justify-content-between mt-3 pt-2 border-top border-light">
                                <div>
                                    @if ($task->assignee)
                                        <img src="{{ $task->assignee->avatar_url }}" 
                                             class="rounded-circle border border-white" width="24" height="24" title="{{ $task->assignee->name }}" style="object-fit: cover;">
                                    @else
                                        <div class="rounded-circle border border-dashed d-flex align-items-center justify-content-center text-muted small" style="width: 24px; height: 24px;">?</div>
                                    @endif
                                </div>
                                <div class="d-flex align-items-center gap-3 text-muted small">
                                    <span class="{{ $col['id'] == 'done' ? 'text-success' : '' }}">{{ $task->created_at->format('M d') }}</span>
                                    <div class="d-flex align-items-center gap-1 {{ $task->comments_count > 0 ? 'text-primary' : 'text-muted opacity-50' }}">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                        <span>{{ $task->comments_count }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 bg-light rounded-3 border border-dashed">
                        <div class="text-muted small">No tasks</div>
                    </div>
                @endforelse
            </div>
        </div>
        @endforeach
    </div>

    {{-- Create Task Modal --}}
    <div class="modal fade" id="createTaskModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-bold">Add New Task</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="saveTask">
                        <input type="text" class="form-control mb-3" placeholder="Task title..." wire:model="title">
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <select class="form-select form-select-sm" wire:model="status">
                                    <option value="To-Do">To Do</option>
                                    <option value="In-Progress">In Progress</option>
                                    <option value="Done">Done</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <select class="form-select form-select-sm" wire:model="priority">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                    <option value="critical">Critical</option>
                                </select>
                            </div>
                        </div>
                        <textarea class="form-control mb-3" rows="3" placeholder="Description..." wire:model="description"></textarea>
                        <select class="form-select mb-3" wire:model="assignee_id">
                            <option value="">Unassigned</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary w-100">Create Task</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Comments Modal --}}
    <div class="modal fade" id="commentsModal" tabindex="-1" wire:ignore.self> 
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg overflow-hidden" style="height: 80vh;">
          <div class="modal-body p-0 h-100">
            @if ($taskWithComments)
                @livewire('task-comments', ['task' => $taskWithComments], key($taskWithComments->id))
            @else
                <div class="d-flex align-items-center justify-content-center h-100"><div class="spinner-border text-primary"></div></div>
            @endif
          </div>
        </div>
      </div>
    </div>
</div>