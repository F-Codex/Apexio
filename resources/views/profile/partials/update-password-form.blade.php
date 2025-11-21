<section class="mt-3">
    <form method="post" action="{{ route('password.update') }}" style="max-width: 400px;">
        @csrf
        @method('put')

        <div class="mb-4">
            <label for="current_password" class="form-label small fw-bold text-secondary">CURRENT PASSWORD</label>
            <input type="password" id="current_password" name="current_password" class="form-control bg-light border-0 focus-ring" autocomplete="current-password">
            @error('current_password', 'updatePassword') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="form-label small fw-bold text-secondary">NEW PASSWORD</label>
            <input type="password" id="password" name="password" class="form-control bg-light border-0 focus-ring" autocomplete="new-password">
            @error('password', 'updatePassword') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label small fw-bold text-secondary">CONFIRM PASSWORD</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control bg-light border-0 focus-ring" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex align-items-center gap-3 mt-5">
            <button type="submit" class="btn btn-primary px-4 fw-medium">Update Password</button>

            @if (session('status') === 'password-updated')
                <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                      class="small text-success fw-medium d-flex align-items-center gap-1">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Saved
                </span>
            @endif
        </div>
    </form>
</section>