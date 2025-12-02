export class EventFilter {
    constructor() {
        this.currentFilter = 'all';
        this.initEventInteractions();
    }

    initEventInteractions() {
        // Guardar eventos
        document.querySelectorAll('.btn-save-event').forEach(button => {
            button.addEventListener('click', (e) => {
                this.toggleSaveEvent(e.target);
            });
        });

        // Efectos hover en eventos
        document.querySelectorAll('.event-card').forEach(card => {
            card.addEventListener('mouseenter', this.animateEventCard);
            card.addEventListener('mouseleave', this.resetEventCard);
        });
    }

    toggleSaveEvent(button) {
        const eventId = button.getAttribute('data-event-id');
        const isSaved = button.classList.contains('saved');
        
        if (isSaved) {
            // Quitar de guardados
            button.classList.remove('saved');
            button.innerHTML = '<i class="far fa-bookmark"></i>';
            this.showToast('Evento removido de guardados', 'info');
        } else {
            // Guardar evento
            button.classList.add('saved');
            button.innerHTML = '<i class="fas fa-bookmark"></i>';
            this.showToast('Evento guardado correctamente', 'success');
            
            // Animación de confirmación
            this.animateSaveButton(button);
        }
        
        // Aquí iría la llamada API para guardar/remover
        this.saveEventToAPI(eventId, !isSaved);
    }

    animateSaveButton(button) {
        button.style.transform = 'scale(1.3)';
        setTimeout(() => {
            button.style.transform = 'scale(1)';
        }, 300);
    }

    animateEventCard(e) {
        const card = e.currentTarget;
        const image = card.querySelector('.card-image img');
        const badge = card.querySelector('.event-badge');
        
        // Efecto en el badge
        if (badge) {
            badge.style.transform = 'scale(1.1)';
        }
    }

    resetEventCard(e) {
        const card = e.currentTarget;
        const badge = card.querySelector('.event-badge');
        
        if (badge) {
            badge.style.transform = 'scale(1)';
        }
    }

    async saveEventToAPI(eventId, save) {
        try {
            const response = await fetch('/api/events/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    event_id: eventId,
                    save: save
                })
            });
            
            if (!response.ok) {
                throw new Error('Error al guardar evento');
            }
            
            return await response.json();
        } catch (error) {
            console.error('Error:', error);
            this.showToast('Error al guardar evento', 'error');
        }
    }

    showToast(message, type = 'info') {
        // Implementar un sistema de notificaciones toast
        console.log(`[${type.toUpperCase()}] ${message}`);
        
        // Ejemplo simple de toast
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.textContent = message;
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            background: ${type === 'success' ? '#10B981' : type === 'error' ? '#EF4444' : '#3B82F6'};
            color: white;
            border-radius: 0.5rem;
            z-index: 1000;
            animation: slideIn 0.3s ease;
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
}