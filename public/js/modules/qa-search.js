export class QASearch {
    constructor() {
        this.initQuickQuestions();
        this.initSearchSuggestions();
        this.initQuickFilters();
    }

    initQuickQuestions() {
        document.querySelectorAll('.suggestion-tag').forEach(button => {
            button.addEventListener('click', (e) => {
                const query = e.target.getAttribute('data-query');
                this.performSearch(query);
            });
        });
    }

    initQuickFilters() {
        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                // Remover active de todos
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                
                // Agregar active al clickeado
                e.target.classList.add('active');
                
                const filter = e.target.getAttribute('data-filter');
                this.filterEvents(filter);
            });
        });
    }

    performSearch(query) {
        const searchInput = document.querySelector('.qa-search-input');
        const searchForm = document.querySelector('.qa-search-form');
        
        searchInput.value = query;
        searchForm.submit();
    }

    filterEvents(filterType) {
        const events = document.querySelectorAll('.event-card');
        
        events.forEach(event => {
            let show = false;
            
            switch(filterType) {
                case 'all':
                    show = true;
                    break;
                case 'free':
                    show = event.getAttribute('data-event-type') === 'free';
                    break;
                case 'this_week':
                    const eventDate = new Date(event.getAttribute('data-event-date'));
                    const today = new Date();
                    const nextWeek = new Date(today.getTime() + 7 * 24 * 60 * 60 * 1000);
                    show = eventDate >= today && eventDate <= nextWeek;
                    break;
                case 'workshop':
                    const title = event.querySelector('.card-title').textContent.toLowerCase();
                    show = title.includes('taller') || title.includes('workshop');
                    break;
            }
            
            event.style.display = show ? 'block' : 'none';
        });
    }

    initSearchSuggestions() {
        const searchInput = document.querySelector('.qa-search-input');
        
        searchInput.addEventListener('input', this.debounce((e) => {
            this.fetchSuggestions(e.target.value);
        }, 300));
    }

    async fetchSuggestions(query) {
        if (query.length < 2) return;
        
        try {
            const response = await fetch(`/api/search/suggestions?q=${encodeURIComponent(query)}`);
            const suggestions = await response.json();
            this.displaySuggestions(suggestions);
        } catch (error) {
            console.error('Error fetching suggestions:', error);
        }
    }

    debounce(func, wait) {
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
}