// Mobile Menu Toggle
const menuToggle = document.getElementById('menuToggle');
const navMenu = document.querySelector('.nav-menu');

if (menuToggle && navMenu) {
    menuToggle.addEventListener('click', () => {
        navMenu.classList.toggle('active');
        menuToggle.classList.toggle('active');
    });
}

// Search Toggle
const searchToggle = document.getElementById('searchToggle');
const searchBar = document.getElementById('searchBar');
const closeSearch = document.getElementById('closeSearch');

if (searchToggle && searchBar) {
    searchToggle.addEventListener('click', () => {
        searchBar.classList.add('active');
    });
    
    if (closeSearch) {
        closeSearch.addEventListener('click', () => {
            searchBar.classList.remove('active');
        });
    }
}

// Close menus when clicking outside
document.addEventListener('click', (e) => {
    if (!e.target.closest('.nav-menu') && !e.target.closest('.menu-toggle')) {
        navMenu?.classList.remove('active');
    }
    
    if (!e.target.closest('.search-bar') && !e.target.closest('.search-toggle')) {
        searchBar?.classList.remove('active');
    }
});

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Add to cart functionality
document.querySelectorAll('.btn-primary').forEach(button => {
    if (button.textContent.includes('🛒')) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productCard = this.closest('.product-card');
            const productName = productCard?.querySelector('.product-title')?.textContent;
            
            if (productName) {
                // Simulate adding to cart
                const cartCount = document.querySelector('.cart-count');
                if (cartCount) {
                    let count = parseInt(cartCount.textContent) || 0;
                    cartCount.textContent = count + 1;
                    cartCount.style.animation = 'bounce 0.5s';
                    setTimeout(() => cartCount.style.animation = '', 500);
                }
                
                // Show feedback
                this.textContent = '✅ Agregado';
                this.style.background = '#28a745';
                setTimeout(() => {
                    this.textContent = '🛒 Agregar';
                    this.style.background = '';
                }, 2000);
            }
        });
    }
});

// Wishlist functionality
document.querySelectorAll('.wishlist-btn, .btn-icon').forEach(button => {
    if (button.innerHTML.includes('❤️')) {
        button.addEventListener('click', function() {
            this.classList.toggle('active');
            if (this.classList.contains('active')) {
                this.innerHTML = '💖';
                this.style.background = 'var(--terracota)';
                this.style.color = 'var(--blanco)';
            } else {
                this.innerHTML = '❤️';
                this.style.background = '';
                this.style.color = '';
            }
        });
    }
});