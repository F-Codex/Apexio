<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Apexio') }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased overflow-hidden">
    <div class="app-wrapper">
        
        {{-- SIDEBAR --}}
        <aside class="app-sidebar">
            <div class="sidebar-header">
                <div class="logo-box">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <span class="fs-5 fw-bold text-white tracking-tight" style="font-size: 1.1rem;">Apexio</span>
            </div>

            <div class="sidebar-content">
                <div class="nav-section">
                    <div class="section-title">MAIN MENU</div>
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        Dashboard
                    </a>
                    <a href="#" class="nav-link">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        My Tasks
                    </a>
                </div>

                <div class="nav-section">
                    <div class="d-flex align-items-center justify-content-between pe-2">
                        <div class="section-title mb-0">PROJECTS</div>
                        <button class="btn btn-link p-0 text-secondary" onclick="Livewire.dispatch('open-create-modal')">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </button>
                    </div>
                    <div class="mt-2"></div>

                    @php 
                        $userProjects = Auth::user()->projects()->latest()->take(10)->get();
                        $colors = ['#3b82f6', '#f97316', '#22c55e', '#a855f7', '#ec4899', '#eab308', '#06b6d4'];
                    @endphp

                    @forelse($userProjects as $index => $proj)
                        @php
                            $isActive = request()->routeIs('project.detail') && request()->route('project')->id == $proj->id;
                            $dotColor = $colors[$index % count($colors)];
                        @endphp
                        
                        <a href="{{ route('project.detail', $proj) }}" 
                           class="nav-link {{ $isActive ? 'active' : '' }}">
                            <span class="project-dot" style="background-color: {{ $dotColor }};"></span>
                            <span class="text-truncate">{{ $proj->name }}</span>
                        </a>
                    @empty
                        <div class="px-3 py-2 text-muted small fst-italic" style="font-size: 0.8rem;">No projects yet</div>
                    @endforelse
                </div>
            </div>

            <div class="sidebar-footer">
                <div class="dropdown dropup w-100">
                    <a href="#" class="user-dropdown-btn dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="{{ Auth::user()->avatar_url }}" 
                             class="avatar" width="36" height="36">
                        <div class="info">
                            <div class="name">{{ Auth::user()->name }}</div>
                            <div class="email">{{ Auth::user()->email }}</div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark shadow-lg w-100 mb-2 border-0">
                        <li><a class="dropdown-item small" href="{{ route('profile.edit') }}">Profile Settings</a></li>
                        <li><hr class="dropdown-divider border-secondary"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger small" type="submit">Sign Out</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="app-content">
            {{ $slot }}
        </main>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            const bs = window.bootstrap;
            Livewire.on('open-create-modal', () => bs.Modal.getOrCreateInstance('#createProjectModal').show());
            Livewire.on('close-create-modal', () => bs.Modal.getInstance('#createProjectModal')?.hide());
            Livewire.on('open-modal', (id) => {
                const modalId = Array.isArray(id) ? id[0] : (id || 'commentsModal');
                bs.Modal.getOrCreateInstance('#' + modalId).show();
            });
            Livewire.on('close-modal', () => bs.Modal.getInstance('#commentsModal')?.hide());
        });
    </script>
</body>
</html>