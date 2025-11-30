import Sortable from 'sortablejs';

document.addEventListener('livewire:initialized', () => {
    initializeKanban();
    initRealTimeDueDates();

    // Re-calculate badges after Livewire updates to prevent UI flicker
    Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {
        succeed(({ snapshot, effect }) => {
            setTimeout(() => {
                updateDueDateBadges();
            }, 0);
        });
    });
});

function initializeKanban() {
    const columns = document.querySelectorAll('.kanban-tasks-list');

    columns.forEach(column => {
        new Sortable(column, {
            group: 'kanban-board',
            animation: 150,
            ghostClass: 'kanban-ghost',
            dragClass: 'kanban-drag',
            
            // Restrict dragging to authorized elements only
            draggable: '.js-draggable-task', 
            
            delay: 100,
            delayOnTouchOnly: true,

            onEnd: function (evt) {
                const itemEl = evt.item;
                const newStatus = evt.to.getAttribute('data-status');
                const taskId = itemEl.getAttribute('data-task-id');
                const oldStatus = evt.from.getAttribute('data-status');

                if (newStatus !== oldStatus) {
                    const livewireComponent = Livewire.find(
                        itemEl.closest('[wire\\:id]').getAttribute('wire:id')
                    );

                    if (livewireComponent) {
                        livewireComponent.updateTaskStatus(taskId, newStatus);
                        
                        // Immediately update visual badge status
                        const badge = itemEl.querySelector('.js-due-date-badge');
                        if (badge) {
                            badge.setAttribute('data-status-task', newStatus);
                            updateDueDateBadges();
                        }
                    }
                }
            }
        });
    });
}

// Toast Notification Handler
window.addEventListener('task-notification', event => {
    const data = event.detail[0] || event.detail;
    showNotification(data.message, data.type);
});

function showNotification(message, type = 'success') {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'position-fixed bottom-0 end-0 p-3';
        container.style.zIndex = '1070';
        document.body.appendChild(container);
    }

    const toastId = 'toast-' + Date.now();
    const colorClass = type === 'error' ? 'text-bg-danger' : (type === 'info' ? 'text-bg-info' : 'text-bg-success');

    const html = `
        <div id="${toastId}" class="toast align-items-center ${colorClass} border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
    const toastElement = document.getElementById(toastId);
    if (window.bootstrap) {
        const bsToast = new window.bootstrap.Toast(toastElement);
        bsToast.show();
    }

    toastElement.addEventListener('hidden.bs.toast', () => {
        toastElement.remove();
    });
}

// Real-time Due Date Tracker
function initRealTimeDueDates() {
    setInterval(() => {
        updateDueDateBadges();
    }, 10000); 
    
    updateDueDateBadges();
}

function updateDueDateBadges() {
    const badges = document.querySelectorAll('.js-due-date-badge');
    const now = new Date();

    badges.forEach(badge => {
        const dateString = badge.getAttribute('data-due-date');
        const taskStatus = badge.getAttribute('data-status-task');
        const textSpan = badge.querySelector('.due-status-text');
        
        if (taskStatus === 'Done') {
            badge.classList.remove('overdue', 'due-soon');
            if (textSpan) textSpan.textContent = '';
            return;
        }

        if (!dateString) return;

        const dueDate = new Date(dateString);
        const diffMs = dueDate - now;
        const diffHours = diffMs / (1000 * 60 * 60);

        badge.classList.remove('overdue', 'due-soon');

        if (diffMs < 0) {
            badge.classList.add('overdue');
            if (textSpan) textSpan.textContent = '(Late)';
        } else if (diffHours <= 24) {
            badge.classList.add('due-soon');
            if (textSpan) textSpan.textContent = '(Soon)';
        } else {
            if (textSpan) textSpan.textContent = '';
        }
    });
}