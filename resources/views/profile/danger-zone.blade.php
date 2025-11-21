@component('profile.layout')
    <h4 class="fw-bold text-danger mb-4">Danger Zone</h4>
    
    <div class="p-4 bg-danger-subtle bg-opacity-50 rounded-3 border border-danger-subtle mb-4">
        <h6 class="fw-bold text-danger">Delete Account</h6>
        <p class="text-danger-emphasis small mb-3">
            Once your account is deleted, all of its resources and data will be permanently deleted.
        </p>
        @include('profile.partials.delete-user-form')
    </div>
@endcomponent