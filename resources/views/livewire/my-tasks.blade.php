<div class="d-flex flex-column h-100">
    {{-- Header --}}
    <div class="page-header pb-0 pt-4 px-4 border-bottom flex-shrink-0">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h1 class="h3 fw-bold text-dark mb-1">My Assigned Tasks</h1>
                <p class="text-muted small mb-0">
                    Track all tasks assigned to you across different projects.
                </p>
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="page-content bg-light p-4 flex-grow-1" style="background-color: #f8fafc !important;">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                @if($tasks->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light border-bottom">
                            <tr>
                                <th scope="col" class="ps-4 py-3 text-muted small fw-bold text-uppercase" style="width: 40%">Task</th>
                                <th scope="col" class="py-3 text-muted small fw-bold text-uppercase">Project</th>
                                <th scope="col" class="py-3 text-muted small fw-bold text-uppercase">Priority</th>
                                <th scope="col" class="py-3 text-muted small fw-bold text-uppercase">Due Date</th>
                                <th scope="col" class="pe-4 py-3 text-end text-muted small fw-bold text-uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @foreach($tasks as $task)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark mb-1">{{ $task->title }}</span>
                                        <span class="text-muted small text-truncate" style="max-width: 300px;">
                                            {{ Str::limit($task->description ?? 'No description', 60) }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border fw-medium">
                                        {{ $task->project->name }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $prioClass = match($task->priority) {
                                            'critical' => 'bg-danger-subtle text-danger',
                                            'high' => 'bg-warning-subtle text-warning-emphasis',
                                            'medium' => 'bg-primary-subtle text-primary',
                                            'low' => 'bg-secondary-subtle text-secondary',
                                            default => 'bg-light text-muted'
                                        };
                                    @endphp
                                    <span class="badge {{ $prioClass }} text-uppercase" style="font-size: 0.7rem;">
                                        {{ $task->priority }}
                                    </span>
                                </td>
                                
                                {{-- Real-time Due Date Display --}}
                                <td>
                                    @if($task->due_date)
                                        @php
                                            $nowStr = now()->format('Y-m-d H:i:s');
                                            $dueStr = $task->due_date->format('Y-m-d H:i:s');
                                            
                                            $isOverdue = $dueStr < $nowStr && $task->status !== 'Done';
                                            $diffHours = (strtotime($dueStr) - strtotime($nowStr)) / 3600;
                                            $isDueSoon = !$isOverdue && $diffHours <= 24 && $task->status !== 'Done';

                                            $initialClass = $isOverdue ? 'overdue' : ($isDueSoon ? 'due-soon' : '');
                                            $initialText = $isOverdue ? '(Late)' : ($isDueSoon ? '(Soon)' : '');
                                        @endphp

                                        <span class="badge-due-date js-due-date-badge {{ $initialClass }}" 
                                              style="font-size: 0.8rem; padding: 4px 10px;"
                                              title="{{ $task->due_date->format('d M Y H:i') }}"
                                              data-due-date="{{ $task->due_date->format('Y-m-d\TH:i:s') }}"
                                              data-status-task="{{ $task->status }}">
                                            
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px; height:14px; margin-bottom:1px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            
                                            {{ $task->due_date->format('M d, H:i') }}
                                            
                                            <span class="due-status-text ms-1 fw-bold">{{ $initialText }}</span>
                                        </span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>

                                <td class="text-end pe-4">
                                    <a href="{{ route('project.detail', $task->project_id) }}" class="btn btn-sm btn-outline-primary fw-medium px-3" style="border-radius: 6px;">
                                        Open Board
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($tasks->hasPages())
                <div class="px-4 py-3 border-top">
                    {{ $tasks->links() }}
                </div>
                @endif

                @else
                    {{-- Empty State --}}
                    <div class="text-center py-5">
                        <div class="mb-3 p-3 bg-light rounded-circle d-inline-flex">
                            <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="text-muted opacity-50"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h5 class="fw-bold text-dark">All Caught Up!</h5>
                        <p class="text-muted small mb-0">You have no pending tasks assigned to you.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>