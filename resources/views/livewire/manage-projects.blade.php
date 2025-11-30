<div>
    <div class="dashboard-header">
        <div>
            <h2 class="h4 fw-bold mb-1">My Projects</h2>
            <p class="text-muted small mb-0">Manage your workspace and team projects</p>
        </div>
    </div>

    <div class="project-grid">
        {{-- Create New Project Card --}}
        <div wire:click="openCreateModal" class="add-project-card">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span class="fw-bold small">Create New Project</span>
        </div>

        {{-- Project Cards --}}
        @foreach ($projects as $project)
            <a href="{{ route('project.detail', $project) }}" class="text-decoration-none">
                <div class="project-card-modern">
                    <div class="card-icon">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    
                    <h5 class="text-truncate">{{ $project->name }}</h5>
                    <p class="text-truncate-2">{{ $project->description ?? 'No description provided.' }}</p>
                    
                    <div class="card-footer-meta">
                        <div class="owner">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($project->owner->name) }}&background=random" alt="">
                            <span>{{ $project->owner->name }}</span>
                        </div>
                        <span class="badge bg-light text-secondary border">{{ $project->created_at->format('d M') }}</span>
                    </div>

                    @can('delete', $project)
                        <button class="btn btn-sm btn-light text-danger btn-delete-absolute"
                                wire:click.prevent="deleteProject({{ $project->id }})"
                                wire:confirm="Delete this project?">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    @endcan
                </div>
            </a>
        @endforeach
    </div>

    {{-- Create Project Modal --}}
    <div class="modal fade" id="createProjectModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="saveProject">
                    <div class="modal-header">
                        <h5 class="modal-title">Create New Project</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Project Name</label>
                            <input type="text" class="form-control" wire:model="name">
                            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="3" wire:model="description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>