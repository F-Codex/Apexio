<section>
    <button class="btn btn-danger fw-medium" 
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        Delete Account
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
            @csrf
            @method('delete')

            <div class="text-center mb-4">
                <div class="mx-auto bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h2 class="h5 fw-bold text-dark">Delete Account</h2>
                <p class="text-muted small">
                    Are you sure you want to delete your account? This action is irreversible.
                </p>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label visually-hidden">Password</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       class="form-control bg-light border-0 focus-ring" 
                       placeholder="Enter your password to confirm"
                       >
                @error('password', 'userDeletion') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-light fw-medium" x-on:click="$dispatch('close')">
                    Cancel
                </button>

                <button type="submit" class="btn btn-danger fw-medium">
                    Delete Account
                </button>
            </div>
        </form>
    </x-modal>
</section>