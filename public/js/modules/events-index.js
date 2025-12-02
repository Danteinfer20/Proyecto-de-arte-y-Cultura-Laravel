// resources/js/pages/events-index.js
document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const locationFilter = document.getElementById('locationFilter');
    const dateFilter = document.getElementById('dateFilter');
    const eventsGrid = document.getElementById('eventsGrid');
    const eventCards = document.querySelectorAll('.event-card');
    const totalLocations = document.getElementById('totalLocations');

    // Filtros activos
    let activeFilters = {
        search: '',
        category: '',
        location: '',
        date: ''
    };

    // Inicializar filtros
    function initFilters() {
        // Event listeners para filtros
        searchInput.addEventListener('input', debounce(handleSearch, 300));
        categoryFilter.addEventListener('change', handleCategoryFilter);
        locationFilter.addEventListener('change', handleLocationFilter);
        dateFilter.addEventListener('change', handleDateFilter);

        // Botones guardar evento
        initSaveButtons();
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

    // Manejar filtro de ubicación
    function handleLocationFilter(e) {
        activeFilters.location = e.target.value;
        applyFilters();
    }

    // Manejar filtro de fecha
    function handleDateFilter(e) {
        activeFilters.date = e.target.value;
        applyFilters();
    }

    // Aplicar todos los filtros
    function applyFilters() {
        let visibleCount = 0;

        eventCards.forEach(card => {
            const category = card.getAttribute('data-category');
            const location = card.getAttribute('data-location');
            const date = card.getAttribute('data-date');
            const title = card.getAttribute('data-title');

            const matchesSearch = !activeFilters.search || 
                                title.includes(activeFilters.search);
            const matchesCategory = !activeFilters.category || 
                                  category === activeFilters.category;
            const matchesLocation = !activeFilters.location || 
                                  location === activeFilters.location;
            const matchesDate = !activeFilters.date || 
                              date === activeFilters.date;

            if (matchesSearch && matchesCategory && matchesLocation && matchesDate) {
                card.style.display = 'block';
                visibleCount++;
                // Animación de entrada
                card.style.animation = 'fadeIn 0.5s ease';
            } else {
                card.style.display = 'none';
            }
        });

        // Mostrar mensaje si no hay resultados
        showNoResultsMessage(visibleCount);
        
        // Actualizar estadísticas
        updateStats(visibleCount);
    }

    // Mostrar mensaje de no resultados
    function showNoResultsMessage(visibleCount) {
        let noResultsMsg = eventsGrid.querySelector('.no-results-message');
        
        if (visibleCount === 0 && !noResultsMsg) {
            noResultsMsg = document.createElement('div');
            noResultsMsg.className = 'no-results-message';
            noResultsMsg.innerHTML = `
                <i class="fas fa-search"></i>
                <h3>No se encontraron eventos</h3>
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
            eventsGrid.appendChild(noResultsMsg);
        } else if (visibleCount > 0 && noResultsMsg) {
            noResultsMsg.remove();
        }
    }

    // Limpiar filtros (función global)
    window.clearFilters = function() {
        searchInput.value = '';
        categoryFilter.value = '';
        locationFilter.value = '';
        dateFilter.value = '';
        
        activeFilters = {
            search: '',
            category: '',
            location: '',
            date: ''
        };
        
        applyFilters();
    };

    // Actualizar estadísticas
    function updateStats(visibleCount) {
        const statNumbers = document.querySelectorAll('.stat-number');
        if (statNumbers[0]) {
            statNumbers[0].textContent = visibleCount;
        }
    }

    // Inicializar botones guardar
    function initSaveButtons() {
        const saveButtons = document.querySelectorAll('.save-event');
        
        saveButtons.forEach(button => {
            button.addEventListener('click', function() {
                const eventId = this.getAttribute('data-event-id');
                toggleSaveEvent(eventId, this);
            });
        });
    }

    // Alternar guardar evento
    function toggleSaveEvent(eventId, button) {
        // Simular llamada API
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        // Aquí iría la llamada real a tu API
        fetch(`/events/${eventId}/save`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualizar UI
                if (data.saved) {
                    button.innerHTML = '<i class="fas fa-bookmark"></i> Guardado';
                    button.style.background = 'var(--success-color)';
                    showNotification('Evento guardado en favoritos', 'success');
                } else {
                    button.innerHTML = '<i class="fas fa-bookmark"></i> Guardar';
                    button.style.background = '';
                    showNotification('Evento removido de favoritos', 'info');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error al guardar el evento', 'error');
            button.innerHTML = '<i class="fas fa-bookmark"></i> Guardar';
        })
        .finally(() => {
            button.disabled = false;
        });
    }

    // Mostrar notificación
    function showNotification(message, type = 'info') {
        // Crear elemento de notificación
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-${getNotificationIcon(type)}"></i>
                <span>${message}</span>
            </div>
        `;

        // Estilos de notificación
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${getNotificationColor(type)};
            color: white;
            padding: 1rem 1.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            z-index: 1000;
            transform: translateX(400px);
            transition: transform 0.3s ease;
        `;

        document.body.appendChild(notification);

        // Animación de entrada
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);

        // Auto-remover
        setTimeout(() => {
            notification.style.transform = 'translateX(400px)';
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

    // Helper para colores de notificación
    function getNotificationColor(type) {
        const colors = {
            success: 'var(--success-color)',
            error: 'var(--accent-color)',
            info: 'var(--primary-color)',
            warning: 'var(--warning-color)'
        };
        return colors[type] || 'var(--primary-color)';
    }

    // Inicializar
    initFilters();
});