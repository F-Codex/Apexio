<section class="profile-update-section">
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="profile-form" id="profile-form">
        @csrf
        @method('patch')

        {{-- Delete photo trigger --}}
        <input type="hidden" name="remove_photo" id="remove_photo_input" value="0">

        {{-- Profile Photo Section --}}
        <div class="avatar-upload-container">
            
            {{-- Hidden File Input --}}
            <input type="file" id="avatar-input" name="avatar" class="d-none" accept="image/*">

            {{-- Avatar Wrapper --}}
            <div class="avatar-wrapper">
                {{-- Current Avatar (Image or Initials) --}}
                <div id="current-avatar-view" class="d-block">
                    @if($user->avatar_path)
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="avatar-circle">
                    @else
                        <div class="avatar-circle avatar-initials">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                {{-- Preview Avatar (Hidden by default) --}}
                <div id="preview-avatar-view" class="d-none">
                    <span class="avatar-circle preview-bg" id="preview-img-bg"></span>
                </div>
            </div>

            {{-- Actions --}}
            <div class="avatar-actions">
                <h6 class="action-title">Profile Photo</h6>
                <p class="action-desc">Update your photo. JPG, PNG, or GIF. Max 2MB.</p>
                
                <div class="btn-group-custom">
                    {{-- Select Button --}}
                    <button type="button" id="select-photo-btn" class="btn btn-sm btn-outline-secondary">
                        Select New Photo
                    </button>

                    {{-- Cancel Preview Button --}}
                    <button type="button" id="cancel-preview-btn" class="btn btn-sm btn-link text-danger d-none">
                        Cancel
                    </button>

                    {{-- Remove Existing Button --}}
                    @if($user->avatar_path)
                        <button type="button" id="delete-photo-btn" class="btn btn-sm btn-link text-danger">
                            Remove Photo
                        </button>
                    @endif
                </div>

                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
            </div>
        </div>
        
        <hr class="separator">

        {{-- Name Input --}}
        <div class="form-group-limit">
            <x-input-label for="name" value="DISPLAY NAME" class="label-custom" />
            <x-text-input id="name" name="name" type="text" class="input-custom" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-1" :messages="$errors->get('name')" />
        </div>

        {{-- Email Input --}}
        <div class="form-group-limit">
            <x-input-label for="email" value="EMAIL ADDRESS" class="label-custom" />
            <x-text-input id="email" name="email" type="email" class="input-custom" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-1" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="verification-notice">
                    <p class="mb-1 text-warning-emphasis fw-medium">
                        Your email address is unverified.
                    </p>
                    <button form="send-verification" class="btn-link-custom">
                        Click here to re-send the verification email.
                    </button>
                </div>
            @endif
        </div>

        {{-- Submit Button --}}
        <div class="form-footer">
            <x-primary-button class="btn-save">{{ __('Save Changes') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="success-message">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Saved
                </div>
            @endif
        </div>
    </form>
</section>