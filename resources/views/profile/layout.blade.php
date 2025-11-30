<x-app-with-sidebar>
    <div class="page-content p-4 p-lg-5 h-100 bg-light">
        <div class="max-w-6xl mx-auto">
            {{-- Page Header --}}
            <div class="mb-5">
                <h1 class="h3 fw-bold text-dark mb-1">Account Settings</h1>
                <p class="text-muted">Manage your personal information and security preferences.</p>
            </div>

            <div class="row g-4 g-lg-5">
                <div class="col-12 col-lg-3">
                    @include('profile.partials.sidebar-nav')
                </div>

                <div class="col-12 col-lg-8">
                    <div class="card border-0 shadow-sm bg-white rounded-4">
                        <div class="card-body p-4 p-lg-5">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-with-sidebar>