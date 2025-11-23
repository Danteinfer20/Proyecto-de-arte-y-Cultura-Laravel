// public/js/menu.js
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    const authLinks = document.querySelector('.auth-links');

    menuToggle.addEventListener('click', function() {
        navLinks.classList.toggle('active');
        authLinks.classList.toggle('active');
        this.classList.toggle('active');
    });

    document.querySelectorAll('.nav-links a, .auth-links a').forEach(link => {
        link.addEventListener('click', () => {
            navLinks.classList.remove('active');
            authLinks.classList.remove('active');
            menuToggle.classList.remove('active');
        });
    });

    document.addEventListener('click', function(event) {
        if (!event.target.closest('.navbar') && 
            (navLinks.classList.contains('active') || authLinks.classList.contains('active'))) {
            navLinks.classList.remove('active');
            authLinks.classList.remove('active');
            menuToggle.classList.remove('active');
        }
    });
});