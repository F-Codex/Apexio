document.addEventListener('DOMContentLoaded', function () {
    const avatarInput = document.getElementById('avatar-input');
    const selectBtn = document.getElementById('select-photo-btn');
    const cancelBtn = document.getElementById('cancel-preview-btn');
    const currentAvatarView = document.getElementById('current-avatar-view');
    const previewAvatarView = document.getElementById('preview-avatar-view');
    const previewImgBg = document.getElementById('preview-img-bg');
    
    // Trigger file input click
    if (selectBtn && avatarInput) {
        selectBtn.addEventListener('click', function (e) {
            e.preventDefault();
            avatarInput.click();
        });
    }

    // Handle file selection change
    if (avatarInput) {
        avatarInput.addEventListener('change', function () {
            const file = this.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function (e) {
                    previewImgBg.style.backgroundImage = `url('${e.target.result}')`;
                    
                    currentAvatarView.classList.remove('d-block');
                    currentAvatarView.classList.add('d-none');
                    
                    previewAvatarView.classList.remove('d-none');
                    previewAvatarView.classList.add('d-block');
                    
                    cancelBtn.classList.remove('d-none');
                }
                
                reader.readAsDataURL(file);
            }
        });
    }

    // Handle cancel preview
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function () {
            avatarInput.value = null;
            
            previewAvatarView.classList.remove('d-block');
            previewAvatarView.classList.add('d-none');
            
            currentAvatarView.classList.remove('d-none');
            currentAvatarView.classList.add('d-block');
            
            cancelBtn.classList.add('d-none');
        });
    }
    
    const deleteBtn = document.getElementById('delete-photo-btn');
    const removePhotoInput = document.getElementById('remove_photo_input');
    const profileForm = document.getElementById('profile-form');

    if (deleteBtn && removePhotoInput && profileForm) {
        deleteBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if(confirm('Are you sure you want to remove your profile photo?')) {
                removePhotoInput.value = '1';
                profileForm.submit();
            }
        });
    }
});