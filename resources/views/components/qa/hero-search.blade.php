{{-- Componente Q&A Hero Search --}}
<div class="qa-hero-search" data-aos="fade-up" data-aos-delay="300">
    <form class="qa-search-form" action="{{ route('qa.search') }}" method="GET">
        <div class="search-input-wrapper">
            <input type="text" 
                   name="q" 
                   placeholder="¿Qué buscas en la cultura de Popayán? Ej: 'talleres de cerámica', 'eventos música', 'artesanías'" 
                   class="qa-search-input"
                   value="{{ request('q') }}"
                   autocomplete="off">
            <button type="submit" class="qa-search-btn">
                <i class="fas fa-search"></i>
                Buscar
            </button>
        </div>
    </form>
    
    <div class="quick-suggestions">
        <span>Explora rápido:</span>
        <button type="button" class="suggestion-tag" data-query="eventos esta semana">
            <i class="fas fa-calendar"></i> Eventos esta semana
        </button>
        <button type="button" class="suggestion-tag" data-query="talleres artesanales">
            <i class="fas fa-hands"></i> Talleres artesanales
        </button>
        <button type="button" class="suggestion-tag" data-query="artistas pintores">
            <i class="fas fa-palette"></i> Artistas pintores
        </button>
        <button type="button" class="suggestion-tag" data-query="productos artesanías">
            <i class="fas fa-shopping-bag"></i> Productos artesanías
        </button>
    </div>
</div>