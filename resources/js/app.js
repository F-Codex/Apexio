import './bootstrap';
import * as bootstrap from 'bootstrap';
import './profile';
import './kanban';

window.bootstrap = bootstrap;

// Global Event Listeners (Livewire & Modals)
document.addEventListener('livewire:initialized', () => {
    const bs = window.bootstrap;
    if (!bs) {
        console.error('Bootstrap not loaded');
        return;
    }

    // Helper function
    const handleModal = (modalId, action) => {
        const element = document.getElementById(modalId);
        if (element) {
            const instance = bs.Modal.getOrCreateInstance(element);
            action === 'show' ? instance.show() : instance.hide();
        }
    };

    // Create Project Modal
    Livewire.on('open-create-modal', () => handleModal('createProjectModal', 'show'));
    Livewire.on('close-create-modal', () => handleModal('createProjectModal', 'hide'));

    // Comments & Generic Modals
    Livewire.on('open-modal', (id) => {
        const modalId = Array.isArray(id) ? id[0] : (id || 'commentsModal');

        if (modalId === 'confirm-user-deletion') return;

        handleModal(modalId, 'show');
    });

    Livewire.on('close-modal', () => handleModal('commentsModal', 'hide'));
});