export class CategoryExplorer {
    constructor() {
        this.initCategoryInteractions();
    }

    initCategoryInteractions() {
        // Click en categorías
        document.querySelectorAll('.btn-category-explore').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const categorySlug = e.target.getAttribute('data-category');
                this.exploreCategory(categorySlug);
            });
        });

        // Hover effects
        document.querySelectorAll('.category-card').forEach(card => {
            card.addEventListener('mouseenter', this.animateCategoryCard);
            card.addEventListener('mouseleave', this.resetCategoryCard);
        });
    }

    exploreCategory(categorySlug) {
        // Mostrar loading
        this.showCategoryLoading();
        
        // Navegar a la página de categoría o filtrar contenido
        setTimeout(() => {
            window.location.href = `/categorias/${categorySlug}`;
        }, 500);
    }

    animateCategoryCard(e) {
        const card = e.currentTarget;
        const icon = card.querySelector('.category-icon');
        
        // Animación del ícono
        icon.style.transform = 'scale(1.2) rotate(5deg)';
        
        // Efecto de brillo
        card.style.background = 'linear-gradient(135deg, #fff 0%, #f8f9fa 100%)';
    }

    resetCategoryCard(e) {
        const card = e.currentTarget;
        const icon = card.querySelector('.category-icon');
        
        icon.style.transform = 'scale(1) rotate(0deg)';
        card.style.background = 'var(--color-blanco)';
    }

    showCategoryLoading() {
        // Podrías implementar un sweet alert o loading state
        console.log('Cargando categoría...');
    }
}