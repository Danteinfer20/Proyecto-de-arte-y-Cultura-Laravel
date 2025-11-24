{{-- resources/views/dashboard/client.blade.php --}}
{{-- SOLO FRAGMENTO - NO extiende layout --}}
<div class="client-dashboard">
    <h2>Mi Espacio Cultural</h2>
    <div class="client-actions">
        <a href="{{ route('events.index') }}" class="btn btn-primary">Explorar Eventos</a>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Ver Productos</a>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Leer Blog</a>
    </div>
    <p class="text-muted">Descubre la cultura y arte de Popayán</p>
</div>