<div class="d-flex flex-column h-100">
    
    {{-- Toast Notifications --}}
    <div x-data="{ show: false, message: '', type: '' }" 
         x-on:alert.window="show = true; message = $event.detail.message; type = $event.detail.type; setTimeout(() => show = false, 3000)"
         class="position-fixed top-0 end-0 p-3" style="z-index: 1050">
        <div x-show="show" x-transition.duration.300ms
             :class="type === 'error' ? 'bg-danger text-white' : (type === 'success' ? 'bg-success text-white' : 'bg-primary text-white')"
             class="toast align-items-center border-0 show p-2 rounded-3 shadow-lg">
            <div class="d-flex align-items-center px-2">
                <div class="toast-body fw-medium" x-text="message"></div>
                <button type="button" class="btn-close btn-close-white ms-auto" @click="show = false"></button>
            </div>
        </div>
    </div>

    <div class="page-header pb-0 pt-4 px-4 border-bottom flex-shrink-0 bg-white">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold text-dark mb-1">Admin Control Center</h1>
                <p class="text-muted small mb-0">Monitor system health and manage user access.</p>
            </div>
            <div>
                <span class="badge bg-dark px-3 py-2 rounded-pill shadow-sm d-flex align-items-center gap-2">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Super Admin Mode
                </span>
            </div>
        </div>
    </div>

    <div class="page-content bg-light p-4 flex-grow-1" style="background-color: #f8fafc !important;">
        <div class="row g-4 mb-4">
            @foreach([
                ['label' => 'Total Users', 'value' => $stats['users'], 'color' => 'primary', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                ['label' => 'Total Projects', 'value' => $stats['projects'], 'color' => 'success', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
                ['label' => 'Active Tasks', 'value' => $stats['active_tasks'], 'color' => 'warning', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'All Tasks', 'value' => $stats['tasks'], 'color' => 'info', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2']
            ] as $stat)
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 transition-hover">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted small fw-bold text-uppercase mb-1">{{ $stat['label'] }}</p>
                                <h2 class="fw-bold mb-0 text-{{ $stat['color'] }}">{{ $stat['value'] }}</h2>
                            </div>
                            <div class="bg-{{ $stat['color'] }} bg-opacity-10 p-3 rounded-circle text-{{ $stat['color'] }}">
                                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-visible">
            <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center rounded-top-4">
                <h5 class="fw-bold mb-0 text-dark">User Database</h5>
                <div class="position-relative" style="width: 250px;">
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control form-control-sm ps-5 rounded-pill border-light bg-light" placeholder="Search user...">
                    <svg class="position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <div class="table-responsive" style="min-height: 50vh;">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small fw-bold text-uppercase">
                        <tr>
                            <th class="ps-4 py-3">User Profile</th>
                            <th class="py-3">Role</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Joined</th>
                            <th class="pe-4 py-3 text-end">Manage</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @foreach($users as $user)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="position-relative">
                                        @if($user->avatar_path)
                                            <img src="{{ $user->avatar_url }}" class="rounded-circle border shadow-sm" width="42" height="42" style="object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center text-primary fw-bold border border-primary border-opacity-10 shadow-sm" style="width: 42px; height: 42px; font-size: 1.1rem;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $user->name }}</div>
                                        <div class="small text-muted">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($user->is_admin)
                                    <span class="badge bg-dark text-white border px-3 py-2 rounded-pill">Admin</span>
                                @else
                                    <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill">User</span>
                                @endif
                            </td>
                            <td>
                                @if($user->isOnline())
                                    <span class="badge bg-success bg-gradient text-white border border-success px-3 py-2 rounded-pill shadow-sm d-inline-flex align-items-center gap-2">
                                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true" style="width: 0.4rem; height: 0.4rem;"></span>
                                        ONLINE
                                    </span>
                                @else
                                    <span class="badge bg-light text-muted border px-3 py-2 rounded-pill">OFFLINE</span>
                                @endif
                            </td>
                            <td class="text-muted small">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="pe-4 text-end">
                                @if($user->id !== auth()->id())
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-white border shadow-sm rounded-3 px-2 py-1" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-boundary="window">
                                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="text-secondary"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 mt-2 p-2" style="min-width: 200px; z-index: 9999;">
                                            <li><h6 class="dropdown-header text-uppercase small fw-bold text-muted my-1">Access Control</h6></li>
                                            
                                            <li>
                                                <button wire:click="toggleAdmin({{ $user->id }})" class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2">
                                                    @if($user->is_admin)
                                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="text-warning"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                                        <span>Demote to User</span>
                                                    @else
                                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="text-primary"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                                        <span>Promote to Admin</span>
                                                    @endif
                                                </button>
                                            </li>

                                            <li>
                                                <button wire:click="resetPassword({{ $user->id }})" 
                                                        wire:confirm="Reset password to 'password123'?"
                                                        class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2">
                                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="text-secondary"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                                    <span>Reset Password</span>
                                                </button>
                                            </li>

                                            <li><hr class="dropdown-divider my-2"></li>
                                            
                                            <li>
                                                <button wire:click="deleteUser({{ $user->id }})" 
                                                        wire:confirm="PERMANENTLY delete {{ $user->name }}?"
                                                        class="dropdown-item rounded-2 py-2 d-flex align-items-center gap-2 text-danger hover-bg-danger-subtle">
                                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    <span>Delete Account</span>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                @else
                                    <span class="badge bg-light text-muted border px-3">You</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($users->hasPages())
                <div class="px-4 py-3 border-top">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>