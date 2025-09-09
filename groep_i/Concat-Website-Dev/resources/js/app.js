import './bootstrap';

    // Updated JavaScript
    function toggleMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    const overlay = document.querySelector('.overlay');
    mobileMenu.classList.toggle('active');
    overlay.classList.toggle('active');
    document.body.classList.toggle('menu-active');
}

    document.getElementById('nav-button').addEventListener('click', toggleMenu);
    document.querySelector('.close-btn').addEventListener('click', toggleMenu);
    document.querySelector('.overlay').addEventListener('click', toggleMenu);

    // Close menu when clicking outside on mobile
    document.addEventListener('click', (event) => {
    const mobileMenu = document.getElementById('mobile-menu');
    const isClickInside = mobileMenu.contains(event.target);
    const isMenuButton = event.target.closest('#nav-button');

    if (!isClickInside && !isMenuButton && mobileMenu.classList.contains('active')) {
    toggleMenu();
}
});

    window.addEventListener('resize', () => {
    if (window.innerWidth > 768) {
    const mobileMenu = document.getElementById('mobile-menu');
    mobileMenu.classList.remove('active');
    document.querySelector('.overlay').classList.remove('active');
    document.body.classList.remove('menu-active');
}
});
