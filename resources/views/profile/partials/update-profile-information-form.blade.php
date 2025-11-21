<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-3" id="profile-form">
        @csrf
        @method('patch')

        {{-- Delete photo trigger --}}
        <input type="hidden" name="remove_photo" id="remove_photo_input" value="0">

        {{-- Profile Photo --}}
        <div class="mb-5 d-flex align-items-center gap-4">
            
            {{-- Input --}}
            <input type="file" 
                   id="avatar" 
                   name="avatar" 
                   class="d-none" 
                   accept="image/*">

            {{-- Preview --}}
            <div class="flex-shrink-0 position-relative">
                <div id="current-avatar" style="display: block;">
                    <img src="{{ $user->avatar_url }}" 
                         alt="{{ $user->name }}" 
                         class="rounded-circle object-fit-cover shadow-sm border" 
                         style="width: 80px; height: 80px;">
                </div>

                <div id="new-avatar-preview" style="display: none;">
                    <img id="preview-img-tag" 
                         src="" 
                         class="rounded-circle object-fit-cover shadow-sm border" 
                         style="width: 80px; height: 80px;">
                </div>
            </div>

            {{-- Actions --}}
            <div>
                <h6 class="fw-bold mb-1 text-dark">Profile Photo</h6>
                <p class="text-muted small mb-3">Update your photo. JPG, PNG, or GIF. Max 2MB.</p>
                
                <div class="d-flex gap-2 align-items-center">
                    {{-- Select --}}
                    <button type="button" 
                            id="select-photo-btn"
                            class="btn btn-sm btn-outline-secondary fw-medium px-3">
                        Select New Photo
                    </button>

                    {{-- Cancel Preview --}}
                    <button type="button" 
                            id="cancel-preview-btn"
                            class="btn btn-sm btn-link text-danger text-decoration-none px-0 ms-2"
                            style="display: none;">
                        Cancel
                    </button>

                    {{-- Remove Current --}}
                    @if($user->avatar_path)
                    <button type="button" 
                            id="delete-photo-btn"
                            class="btn btn-sm btn-link text-danger text-decoration-none px-0 ms-2">
                        Remove Photo
                    </button>
                    @endif
                </div>

                @error('avatar') 
                    <div class="text-danger small mt-2 fw-bold">
                        <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                    </div> 
                @enderror
            </div>
        </div>
        
        <hr class="text-muted opacity-25 mb-4">

        <div class="mb-4" style="max-width: 450px;">
            <label for="name" class="form-label small fw-bold text-secondary ls-tight">DISPLAY NAME</label>
            <input type="text" id="name" name="name" class="form-control bg-light border-0 focus-ring py-2 px-3" 
                   value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4" style="max-width: 450px;">
            <label for="email" class="form-label small fw-bold text-secondary ls-tight">EMAIL ADDRESS</label>
            <input type="email" id="email" name="email" class="form-control bg-light border-0 focus-ring py-2 px-3" 
                   value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 p-3 bg-warning-subtle rounded small border border-warning-subtle">
                    <p class="mb-1 text-warning-emphasis fw-medium">
                        Your email address is unverified.
                    </p>
                    <button form="send-verification" class="btn btn-link p-0 small align-baseline text-decoration-none fw-bold text-warning-emphasis">
                        Click here to re-send the verification email.
                    </button>
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3 mt-5 pt-3">
            <button type="submit" class="btn btn-primary px-4 py-2 fw-medium shadow-sm">Save Changes</button>

            @if (session('status') === 'profile-updated')
                <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                      class="small text-success fw-bold d-flex align-items-center gap-1 bg-success-subtle px-2 py-1 rounded">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Saved
                </span>
            @endif
        </div>
    </form>
</section>