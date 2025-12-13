<div>
    {{-- Invite Form --}}
    @if($canManageMembers)
        <div class="mb-4">
            <label class="form-label small fw-bold text-secondary" style="letter-spacing: 0.5px;">INVITE TEAM MEMBER</label>
            <form class="d-flex gap-2" wire:submit.prevent="addMember">
                <div class="flex-grow-1">
                    <input type="email" 
                           class="form-control bg-light border-0 focus-ring" 
                           placeholder="Enter email address..." 
                           wire:model="email"
                           autocomplete="off">
                    @error('email') <div class="text-danger small mt-1 fw-bold">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn btn-primary px-4 fw-medium">Invite</button>
            </form>
        </div>
        <hr class="border-light my-4 opacity-50">
    @endif

    {{-- Member List --}}
    <div>
        <label class="form-label small fw-bold text-secondary mb-3" style="letter-spacing: 0.5px;">
            MEMBERS ({{ $members->count() }})
        </label>
        
        <div class="d-flex flex-column gap-3">
            @forelse ($members as $member)
                <div class="d-flex align-items-center justify-content-between p-2 rounded hover-bg-light transition-all">
                    {{-- Avatar & Info --}}
                    <div class="d-flex align-items-center gap-3">
                        @if($member->avatar_path)
                            <img src="{{ $member->avatar_url }}" 
                                 alt="{{ $member->name }}"
                                 class="rounded-circle border border-white shadow-sm" 
                                 width="40" height="40"
                                 style="object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold border border-white shadow-sm" 
                                 style="width: 40px; height: 40px; font-size: 16px;">
                                {{ strtoupper(substr($member->name, 0, 1)) }}
                            </div>
                        @endif
                             
                        <div style="line-height: 1.3;">
                            <div class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $member->name }}</div>
                            <div class="text-muted small" style="font-size: 0.8rem;">{{ $member->email }}</div>
                        </div>
                    </div>
                    
                    {{-- Role Badge --}}
                    <span class="badge {{ $member->pivot->role == 'Admin' ? 'bg-primary-subtle text-primary border border-primary-subtle' : 'bg-secondary-subtle text-secondary border border-secondary-subtle' }} rounded-pill px-3 py-2 fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                        {{ strtoupper($member->pivot->role) }}
                    </span>
                </div>
            @empty
                <div class="text-center text-muted py-4 small bg-light rounded border border-dashed">
                    No members yet.
                </div>
            @endforelse
        </div>
    </div>
</div>