document.addEventListener('DOMContentLoaded', () => {
    const avatarInput = document.getElementById('avatar');
    
    if (avatarInput) {
        // Elements
        const previewImg = document.getElementById('preview-img-tag');
        const newAvatarDiv = document.getElementById('new-avatar-preview');
        const currentAvatarDiv = document.getElementById('current-avatar');
        const cancelBtn = document.getElementById('cancel-preview-btn');
        const deleteBtn = document.getElementById('delete-photo-btn');
        const removePhotoInput = document.getElementById('remove_photo_input');
        const profileForm = document.getElementById('profile-form');
        const selectPhotoBtn = document.getElementById('select-photo-btn');

        // Trigger input file via button
        if(selectPhotoBtn) {
            selectPhotoBtn.addEventListener('click', () => avatarInput.click());
        }

        // 1. Handle File Selection (Preview)
        avatarInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB');
                    event.target.value = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    if(previewImg) previewImg.src = e.target.result;
                    if(newAvatarDiv) newAvatarDiv.style.display = 'block';
                    if(currentAvatarDiv) currentAvatarDiv.style.display = 'none';
                    if(cancelBtn) cancelBtn.style.display = 'inline-block';
                    if(deleteBtn) deleteBtn.style.display = 'none';
                }
                reader.readAsDataURL(file);
            }
        });

        // 2. Handle Cancel Preview
        if (cancelBtn) {
            cancelBtn.addEventListener('click', function() {
                avatarInput.value = '';
                if(newAvatarDiv) newAvatarDiv.style.display = 'none';
                if(currentAvatarDiv) currentAvatarDiv.style.display = 'block';
                this.style.display = 'none';
                if(deleteBtn) deleteBtn.style.display = 'inline-block';
            });
        }

        // 3. Handle Delete Photo
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function() {
                if(confirm('Are you sure you want to remove your profile photo?')) {
                    if(removePhotoInput) removePhotoInput.value = '1';
                    if(profileForm) profileForm.submit();
                }
            });
        }
    }
});