<nav class="nav flex-column nav-pills sticky-top profile-sidebar-nav">
    <a href="{{ route('profile.edit') }}" 
       class="nav-link d-flex align-items-center gap-3 px-3 py-2 fw-medium rounded-3 transition-all {{ request()->routeIs('profile.edit') ? 'active bg-white shadow-sm text-primary border-start border-4 border-primary' : 'text-muted hover-bg-light' }}">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        General
    </a>

    <a href="{{ route('profile.password') }}" 
       class="nav-link d-flex align-items-center gap-3 px-3 py-2 fw-medium rounded-3 transition-all {{ request()->routeIs('profile.password') ? 'active bg-white shadow-sm text-primary border-start border-4 border-primary' : 'text-muted hover-bg-light' }}">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        Password
    </a>

    <a href="{{ route('profile.danger') }}" 
       class="nav-link d-flex align-items-center gap-3 px-3 py-2 fw-medium rounded-3 transition-all {{ request()->routeIs('profile.danger') ? 'active bg-danger-subtle text-danger border-start border-4 border-danger' : 'text-danger hover-bg-danger-subtle' }}">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        Danger Zone
    </a>
</nav>