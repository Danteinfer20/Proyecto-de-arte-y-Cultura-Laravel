// resources/js/pages/products-index.js
document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const typeFilter = document.getElementById('typeFilter');
    const sortFilter = document.getElementById('sortFilter');
    const productsGrid = document.getElementById('productsGrid');
    const productCards = document.querySelectorAll('.product-card');
    const totalArtists = document.getElementById('totalArtists');

    // Filtros activos
    let activeFilters = {
        search: '',
        category: '',
        type: '',
        sort: 'newest'
    };

    // Inicializar
    function init() {
        initFilters();
        initWishlistButtons();
        initAddToCartButtons();
        countUniqueArtists();
    }

    // Inicializar filtros
    function initFilters() {
        searchInput.addEventListener('input', debounce(handleSearch, 300));
        categoryFilter.addEventListener('change', handleCategoryFilter);
        typeFilter.addEventListener('change', handleTypeFilter);
        sortFilter.addEventListener('change', handleSortFilter);
    }

    // Debounce para búsqueda
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Manejar búsqueda
    function handleSearch(e) {
        activeFilters.search = e.target.value.toLowerCase().trim();
        applyFilters();
    }

    // Manejar filtro de categoría
    function handleCategoryFilter(e) {
        activeFilters.category = e.target.value;
        applyFilters();
    }

    // Manejar filtro de tipo
    function handleTypeFilter(e) {
        activeFilters.type = e.target.value;
        applyFilters();
    }

    // Manejar ordenamiento
    function handleSortFilter(e) {
        activeFilters.sort = e.target.value;
        applyFilters();
    }

    // Aplicar todos los filtros y ordenamiento
    function applyFilters() {
        let visibleProducts = [];

        productCards.forEach(card => {
            const category = card.getAttribute('data-category');
            const type = card.getAttribute('data-type');
            const price = parseFloat(card.getAttribute('data-price'));
            const title = card.getAttribute('data-title');
            const sales = parseInt(card.getAttribute('data-sales'));

            const matchesSearch = !activeFilters.search || 
                                title.includes(activeFilters.search);
            const matchesCategory = !activeFilters.category || 
                                  category === activeFilters.category;
            const matchesType = !activeFilters.type || 
                              type === activeFilters.type;

            if (matchesSearch && matchesCategory && matchesType) {
                card.style.display = 'block';
                visibleProducts.push({
                    element: card,
                    price: price,
                    sales: sales,
                    date: card.getAttribute('data-date')
                });
            } else {
                card.style.display = 'none';
            }
        });

        // Ordenar productos visibles
        sortProducts(visibleProducts);

        // Mostrar mensaje si no hay resultados
        showNoResultsMessage(visibleProducts.length);
        
        // Actualizar estadísticas
        updateStats(visibleProducts.length);
    }

    // Ordenar productos
    function sortProducts(products) {
        const container = productsGrid;
        const sortedProducts = [...products];

        switch (activeFilters.sort) {
            case 'price_asc':
                sortedProducts.sort((a, b) => a.price - b.price);
                break;
            case 'price_desc':
                sortedProducts.sort((a, b) => b.price - a.price);
                break;
            case 'popular':
                sortedProducts.sort((a, b) => b.sales - a.sales);
                break;
            case 'newest':
            default:
                // Ya están ordenados por fecha por defecto
                break;
        }

        // Reordenar DOM
        sortedProducts.forEach(product => {
            container.appendChild(product.element);
        });
    }

    // Mostrar mensaje de no resultados
    function showNoResultsMessage(visibleCount) {
        let noResultsMsg = productsGrid.querySelector('.no-results-message');
        
        if (visibleCount === 0 && !noResultsMsg) {
            noResultsMsg = document.createElement('div');
            noResultsMsg.className = 'no-results-message';
            noResultsMsg.innerHTML = `
                <i class="fas fa-search"></i>
                <h3>No se encontraron productos</h3>
                <p>Intenta con otros filtros de búsqueda</p>
                <button class="btn-primary" onclick="clearFilters()">
                    <i class="fas fa-times"></i> Limpiar Filtros
                </button>
            `;
            noResultsMsg.style.cssText = `
                grid-column: 1 / -1;
                text-align: center;
                padding: 4rem 2rem;
                background: var(--white);
                border-radius: var(--border-radius);
                box-shadow: var(--box-shadow);
            `;
            productsGrid.appendChild(noResultsMsg);
        } else if (visibleCount > 0 && noResultsMsg) {
            noResultsMsg.remove();
        }
    }

    // Limpiar filtros (función global)
    window.clearFilters = function() {
        searchInput.value = '';
        categoryFilter.value = '';
        typeFilter.value = '';
        sortFilter.value = 'newest';
        
        activeFilters = {
            search: '',
            category: '',
            type: '',
            sort: 'newest'
        };
        
        applyFilters();
    };

    // Inicializar botones de wishlist
    function initWishlistButtons() {
        const wishlistButtons = document.querySelectorAll('.wishlist');
        
        wishlistButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                toggleWishlist(productId, this);
            });
        });
    }

    // Alternar wishlist
    function toggleWishlist(productId, button) {
        const icon = button.querySelector('i');
        
        // Simular llamada API
        button.disabled = true;

        // Aquí iría la llamada real a tu API
        fetch(`/products/${productId}/wishlist`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.inWishlist) {
                    icon.className = 'fas fa-heart';
                    button.style.color = '#e74c3c';
                    showNotification('Producto agregado a favoritos', 'success');
                } else {
                    icon.className = 'far fa-heart';
                    button.style.color = '';
                    showNotification('Producto removido de favoritos', 'info');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error al actualizar favoritos', 'error');
        })
        .finally(() => {
            button.disabled = false;
        });
    }

    // Inicializar botones de carrito
    function initAddToCartButtons() {
        const addToCartButtons = document.querySelectorAll('.add-to-cart');
        
        addToCartButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                addToCart(productId, this);
            });
        });
    }

    // Agregar al carrito
    function addToCart(productId, button) {
        const originalText = button.innerHTML;
        
        // Simular llamada API
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Agregando...';

        // Aquí iría la llamada real a tu API
        fetch(`/cart/add`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: 1
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Producto agregado al carrito', 'success');
                // Podrías actualizar el contador del carrito aquí
            } else {
                showNotification(data.message || 'Error al agregar al carrito', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error de conexión', 'error');
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = originalText;
        });
    }

    // Contar artistas únicos
    function countUniqueArtists() {
        const artistNames = new Set();
        document.querySelectorAll('.product-card [data-artist]').forEach(el => {
            artistNames.add(el.getAttribute('data-artist'));
        });
        
        if (totalArtists) {
            totalArtists.textContent = artistNames.size;
        }
    }

    // Actualizar estadísticas
    function updateStats(visibleCount) {
        const statNumbers = document.querySelectorAll('.stat-number');
        if (statNumbers[0]) {
            statNumbers[0].textContent = visibleCount;
        }
    }

    // Mostrar notificación
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-${getNotificationIcon(type)}"></i>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        // Animación de entrada
        setTimeout(() => {
            notification.classList.add('show');
        }, 100);

        // Auto-remover
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }

    // Helper para iconos de notificación
    function getNotificationIcon(type) {
        const icons = {
            success: 'check-circle',
            error: 'exclamation-circle',
            info: 'info-circle',
            warning: 'exclamation-triangle'
        };
        return icons[type] || 'info-circle';
    }

    // Inicializar
    init();
});