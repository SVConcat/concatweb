window.addEventListener('DOMContentLoaded', () => {
    navAnimation()
    toggleNavigation();
})

function navAnimation() {
    const desktopNav = document.getElementById('desktop-nav');
    const mobileNav = document.getElementById('mobile-nav');
    const content = document.getElementById('page-content');

    requestAnimationFrame(() => {
        [desktopNav, mobileNav].forEach(nav => {
            if (nav) {
                nav.classList.remove('opacity-0', '-translate-y-6');
                nav.classList.add('opacity-100', 'translate-y-0');
            }
        });

        if (content) {
            content.classList.remove('opacity-0', 'translate-y-4');
            content.classList.add('opacity-100', 'translate-y-0');
        }
    });
}

function toggleNavigation() {
    const openBtn = document.getElementById('menu-open');
    const closeBtn = document.getElementById('menu-close');
    const sidebar = document.getElementById('mobile-sidebar');
    const overlay = document.getElementById('mobile-overlay');

    openBtn.addEventListener('click', () => {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    });

    closeBtn.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });
}
