document.addEventListener('DOMContentLoaded', function() {
    openModal();
    mobileMenu();
});

function openModal() {
    const eventDateInput = document.getElementsByName('start_date')[0];
    const openModalButton = document.getElementById('openModalButton');
    const openModalDeleteButton = document.getElementById('openModalDeleteButton');
    const submitButton = document.getElementById('submitButton');
    const today = new Date().toISOString().split('T')[0];
    const modals = document.getElementsByClassName('modal-wrapper');

    function checkDate() {
        if (eventDateInput) {
            const selectedDate = eventDateInput.value;
            const isArchived = submitButton?.getAttribute('data-state') === 'ARCHIVED';
            if (isArchived) {
                openModalButton?.classList.add('hidden');
                submitButton?.classList.remove('hidden');
            }
            else if (selectedDate < today) {
                openModalButton?.classList.remove('hidden');
                submitButton?.classList.add('hidden');
            }
            else {
                openModalButton?.classList.add('hidden');
                submitButton?.classList.remove('hidden');
            }
        }
    }

    function showModal(button) {
        for (let i = 0; i < modals.length; i++) {
            if (modals[i].id === button.getAttribute('data-modal-id')) {
                modals[i].classList.toggle('hidden');
            }
        }
    }

    if (openModalDeleteButton) {
        openModalDeleteButton.addEventListener('click', function () {
            showModal(openModalDeleteButton);
        });
    }

    if (eventDateInput) {
        eventDateInput.addEventListener('change', checkDate);
    }

    if (openModalButton) {
        openModalButton.addEventListener('click', function () {
            showModal(openModalButton);
        });
    }

    checkDate();
}

function mobileMenu() {
    const toggleButton = document.querySelector('[data-drawer-toggle="#sidebar"]');
    const sidebar = document.querySelector('#sidebar');

    if (toggleButton && sidebar) {
        toggleButton.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });
    }
}
