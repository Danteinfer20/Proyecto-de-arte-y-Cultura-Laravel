{{-- Vista para Visitante/Amante del Arte --}}
<div class="role-dashboard visitor-dashboard">
    <div class="role-header">
        <h3><i class="fas fa-heart"></i> Espacio Cultural</h3>
        <p>Descubre y disfruta del arte de Popayán</p>
    </div>
    
    <div class="action-grid">
        <a href="{{ route('events.index') }}" class="action-card">
            <div class="action-icon">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="action-content">
                <h4>Explorar Eventos</h4>
                <p>Encuentra actividades culturales</p>
            </div>
        </a>
        
        <a href="{{ route('products.index') }}" class="action-card">
            <div class="action-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div class="action-content">
                <h4>Ver Productos</h4>
                <p>Descubre artesanías locales</p>
            </div>
        </a>
        
        <a href="{{ route('posts.index') }}" class="action-card">
            <div class="action-icon">
                <i class="fas fa-newspaper"></i>
            </div>
            <div class="action-content">
                <h4>Leer Blog</h4>
                <p>Artículos sobre cultura</p>
            </div>
        </a>
        
        <a href="#" class="action-card">
            <div class="action-icon">
                <i class="fas fa-bookmark"></i>
            </div>
            <div class="action-content">
                <h4>Mis Favoritos</h4>
                <p>Eventos y productos guardados</p>
            </div>
        </a>
    </div>
</div>