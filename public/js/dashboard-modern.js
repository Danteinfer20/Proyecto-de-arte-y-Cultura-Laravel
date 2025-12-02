// Dashboard Moderno - Funcionalidades Interactivas
class ModernDashboard {
    constructor() {
        this.init();
    }

    init() {
        console.log('🚀 Modern Dashboard initialized');
        
        // Inicializar todos los módulos
        this.initRoleTabs();
        this.initAnimatedCounters();
        this.initCharts();
        this.initQuickActions();
        this.initNotifications();
        this.initRealTimeUpdates();
        this.initSmoothAnimations();
    }

    // 1. Sistema de Tabs por Rol
    initRoleTabs() {
        const roleTabs = document.querySelectorAll('.role-tab');
        const contentPanels = document.querySelectorAll('.content-panel');

        roleTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const targetRole = tab.getAttribute('data-role');
                
                // Remover active de todos
                roleTabs.forEach(t => t.classList.remove('active'));
                contentPanels.forEach(panel => panel.classList.remove('active'));
                
                // Activar tab clickeado
                tab.classList.add('active');
                
                // Mostrar contenido correspondiente
                const targetPanel = document.getElementById(`${targetRole}Panel`);
                if (targetPanel) {
                    targetPanel.classList.add('active');
                    this.triggerPanelLoad(targetRole);
                }
            });
        });
    }

    // 2. Contadores Animados
    initAnimatedCounters() {
        const counters = document.querySelectorAll('.stat-value[data-count]');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(counter => observer.observe(counter));
    }

    animateCounter(element) {
        const target = parseInt(element.getAttribute('data-count'));
        const duration = 2000; // 2 segundos
        const step = target / (duration / 16); // 60fps
        let current = 0;

        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current).toLocaleString();
        }, 16);
    }

    // 3. Gráficos Minimalistas
    initCharts() {
        this.createMiniChart('eventsChart', 75);
        this.createMiniChart('productsChart', 60);
        this.createMiniChart('postsChart', 85);
        this.createMiniChart('usersChart', 90);
    }

    createMiniChart(chartId, percentage) {
        const chart = document.getElementById(chartId);
        if (!chart) return;

        // Crear SVG para gráfico circular minimalista
        const svgNS = "http://www.w3.org/2000/svg";
        const svg = document.createElementNS(svgNS, "svg");
        svg.setAttribute("viewBox", "0 0 40 40");
        svg.setAttribute("width", "40");
        svg.setAttribute("height", "40");

        // Fondo del círculo
        const backgroundCircle = document.createElementNS(svgNS, "circle");
        backgroundCircle.setAttribute("cx", "20");
        backgroundCircle.setAttribute("cy", "20");
        backgroundCircle.setAttribute("r", "18");
        backgroundCircle.setAttribute("fill", "none");
        backgroundCircle.setAttribute("stroke", "rgba(255,255,255,0.3)");
        backgroundCircle.setAttribute("stroke-width", "3");

        // Círculo de progreso
        const progressCircle = document.createElementNS(svgNS, "circle");
        progressCircle.setAttribute("cx", "20");
        progressCircle.setAttribute("cy", "20");
        progressCircle.setAttribute("r", "18");
        progressCircle.setAttribute("fill", "none");
        progressCircle.setAttribute("stroke", "white");
        progressCircle.setAttribute("stroke-width", "3");
        progressCircle.setAttribute("stroke-dasharray", `${2 * Math.PI * 18}`);
        progressCircle.setAttribute("stroke-dashoffset", `${2 * Math.PI * 18 * (1 - percentage / 100)}`);
        progressCircle.setAttribute("stroke-linecap", "round");
        progressCircle.setAttribute("transform", "rotate(-90 20 20)");

        // Animación
        progressCircle.style.transition = "stroke-dashoffset 1.5s ease";

        svg.appendChild(backgroundCircle);
        svg.appendChild(progressCircle);
        chart.appendChild(svg);
    }

    // 4. Acciones Rápidas con Efectos
    initQuickActions() {
        const actionCards = document.querySelectorAll('.quick-action-card');
        
        actionCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-5px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0) scale(1)';
            });

            // Efecto de clic
            card.addEventListener('click', (e) => {
                e.preventDefault();
                this.showLoadingState(card);
                
                // Simular navegación después de animación
                setTimeout(() => {
                    window.location.href = card.href;
                }, 500);
            });
        });
    }

    showLoadingState(element) {
        const originalContent = element.innerHTML;
        element.innerHTML = `
            <div class="loading-spinner">
                <i class="fas fa-spinner fa-spin"></i>
            </div>
            <div style="color: #667eea; font-weight: 600;">Cargando...</div>
        `;
        element.style.pointerEvents = 'none';

        // Restaurar después de 2 segundos si no navega
        setTimeout(() => {
            element.innerHTML = originalContent;
            element.style.pointerEvents = 'auto';
        }, 2000);
    }

    // 5. Sistema de Notificaciones
    initNotifications() {
        // Notificación de bienvenida
        setTimeout(() => {
            this.showNotification({
                title: '¡Bienvenido al Dashboard Moderno!',
                message: 'Explora las nuevas funcionalidades interactivas',
                type: 'success',
                duration: 5000
            });
        }, 1000);

        // Escuchar eventos personalizados para notificaciones
        document.addEventListener('dashboard:notification', (e) => {
            this.showNotification(e.detail);
        });
    }

    showNotification({ title, message, type = 'info', duration = 3000 }) {
        const notification = document.createElement('div');
        notification.className = `dashboard-notification notification-${type}`;
        
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-triangle',
            warning: 'fa-exclamation-circle',
            info: 'fa-info-circle'
        };

        notification.innerHTML = `
            <div class="notification-icon">
                <i class="fas ${icons[type]}"></i>
            </div>
            <div class="notification-content">
                <div class="notification-title">${title}</div>
                <div class="notification-message">${message}</div>
            </div>
            <button class="notification-close">
                <i class="fas fa-times"></i>
            </button>
        `;

        // Estilos dinámicos
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 1rem;
            z-index: 10000;
            max-width: 400px;
            border-left: 4px solid ${this.getNotificationColor(type)};
            animation: slideInRight 0.3s ease;
            transform: translateX(100%);
        `;

        document.body.appendChild(notification);

        // Animación de entrada
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 10);

        // Botón cerrar
        const closeBtn = notification.querySelector('.notification-close');
        closeBtn.addEventListener('click', () => {
            this.hideNotification(notification);
        });

        // Auto-remover
        if (duration > 0) {
            setTimeout(() => {
                this.hideNotification(notification);
            }, duration);
        }
    }

    hideNotification(notification) {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }

    getNotificationColor(type) {
        const colors = {
            success: '#27ae60',
            error: '#e74c3c',
            warning: '#f39c12',
            info: '#3498db'
        };
        return colors[type] || colors.info;
    }

    // 6. Actualizaciones en Tiempo Real
    initRealTimeUpdates() {
        // Simular actualizaciones cada 30 segundos
        setInterval(() => {
            this.updateLiveStats();
        }, 30000);

        // WebSocket simulation para notificaciones en tiempo real
        this.simulateRealtimeNotifications();
    }

    updateLiveStats() {
        const stats = document.querySelectorAll('.modern-stat-card');
        
        stats.forEach(stat => {
            // Efecto de pulso para indicar actualización
            stat.style.animation = 'pulse 0.5s ease';
            setTimeout(() => {
                stat.style.animation = '';
            }, 500);

            // Actualizar números aleatoriamente (en producción vendría del servidor)
            const valueElement = stat.querySelector('.stat-value');
            if (valueElement) {
                const current = parseInt(valueElement.getAttribute('data-count'));
                const change = Math.floor(Math.random() * 10) - 2; // -2 to +7
                const newValue = Math.max(0, current + change);
                
                valueElement.setAttribute('data-count', newValue);
                this.animateCounter(valueElement);
            }
        });

        // Notificar actualización
        this.showNotification({
            title: 'Estadísticas Actualizadas',
            message: 'Los datos se han actualizado en tiempo real',
            type: 'info',
            duration: 2000
        });
    }

    simulateRealtimeNotifications() {
        const notifications = [
            {
                title: 'Nuevo Evento Creado',
                message: 'Se ha publicado un nuevo evento cultural',
                type: 'success'
            },
            {
                title: 'Producto Popular',
                message: 'Tu producto está recibiendo mucha atención',
                type: 'info'
            },
            {
                title: 'Recordatorio',
                message: 'Tienes eventos próximos esta semana',
                type: 'warning'
            }
        ];

        // Mostrar notificaciones aleatorias cada 45-90 segundos
        setInterval(() => {
            const randomNotif = notifications[Math.floor(Math.random() * notifications.length)];
            this.showNotification({
                ...randomNotif,
                duration: 4000
            });
        }, 45000 + Math.random() * 45000);
    }

    // 7. Animaciones Suaves
    initSmoothAnimations() {
        // Observador para animaciones al hacer scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observar elementos con data-aos
        document.querySelectorAll('[data-aos]').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s ease';
            observer.observe(el);
        });
    }

    // 8. Carga Dinámica de Paneles
    triggerPanelLoad(panelType) {
        // Emitir evento personalizado para que los paneles específicos se carguen
        const event = new CustomEvent(`dashboard:${panelType}:load`, {
            detail: { panel: panelType, timestamp: Date.now() }
        });
        document.dispatchEvent(event);

        // Mostrar notificación de cambio
        this.showNotification({
            title: `Panel ${this.getPanelName(panelType)}`,
            message: 'Contenido cargado correctamente',
            type: 'info',
            duration: 1500
        });
    }

    getPanelName(panelType) {
        const names = {
            overview: 'Vista General',
            admin: 'Administración',
            artist: 'Estudio Artístico',
            manager: 'Gestión Cultural',
            visitor: 'Descubrimiento'
        };
        return names[panelType] || panelType;
    }

    // 9. Utilidades Globales
    static formatNumber(number) {
        return new Intl.NumberFormat('es-CO').format(number);
    }

    static formatCurrency(amount) {
        return new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP'
        }).format(amount);
    }

    static formatDate(date) {
        return new Intl.DateTimeFormat('es-CO', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        }).format(new Date(date));
    }
}

// Inicialización cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    window.dashboard = new ModernDashboard();
    
    // Agregar estilos CSS dinámicos para animaciones
    const styles = `
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
        
        .loading-spinner {
            color: #667eea;
            font-size: 1.2rem;
        }
        
        .dashboard-notification {
            transition: transform 0.3s ease;
        }
    `;
    
    const styleSheet = document.createElement('style');
    styleSheet.textContent = styles;
    document.head.appendChild(styleSheet);
});

// Exportar para uso global
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ModernDashboard;
}