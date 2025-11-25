{{-- resources/views/dashboard/artist.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <div class="role-dashboard artist-dashboard">
        {{-- Header Personalizado --}}
        <div class="artist-hero-section">
            <div class="hero-content">
                <div class="artist-avatar">
                    @if(Auth::user()->profile_picture)
                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Avatar" class="avatar-image">
                    @else
                        <div class="avatar-placeholder">
                            <i class="fas fa-palette"></i>
                        </div>
                    @endif
                </div>
                <div class="hero-text">
                    <h1>¡Bienvenido, {{ Auth::user()->name }}!</h1>
                    <p>{{ Auth::user()->bio ?? 'Gestiona tu arte, conecta con amantes del arte y haz crecer tu carrera' }}</p>
                    <div class="artist-location">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ Auth::user()->city ?? 'Popayán' }}, {{ Auth::user()->neighborhood ?? 'Cauca' }}
                    </div>
                </div>
            </div>
            <div class="hero-actions">
                <span class="badge badge-artist">{{ ucfirst(Auth::user()->user_type) }}</span>
                <a href="{{ route('profile.edit') }}" class="btn-profile">
                    <i class="fas fa-user-edit"></i> Editar Perfil
                </a>
            </div>
        </div>

        {{-- Estadísticas Reales del Artista --}}
        <div class="artist-real-stats">
            <h3><i class="fas fa-chart-bar"></i> Tu Impacto Artístico</h3>
            <div class="stats-grid-real">
                <div class="real-stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ Auth::user()->posts_count ?? Auth::user()->posts->count() ?? 0 }}</div>
                        <div class="stat-label">Obras Publicadas</div>
                    </div>
                </div>
                
                <div class="real-stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ Auth::user()->userStatistics->follower_count ?? 0 }}</div>
                        <div class="stat-label">Seguidores</div>
                    </div>
                </div>
                
                <div class="real-stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ Auth::user()->userStatistics->sales_count ?? 0 }}</div>
                        <div class="stat-label">Ventas Totales</div>
                    </div>
                </div>
                
                <div class="real-stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">${{ number_format(Auth::user()->userStatistics->total_revenue ?? 0, 0) }}</div>
                        <div class="stat-label">Ingresos Generados</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Acciones Principales del Artista --}}
        <div class="artist-quick-actions">
            <h3><i class="fas fa-rocket"></i> Gestión de tu Arte</h3>
            <div class="actions-grid-artist">
                <a href="{{ url('/posts/create') }}" class="action-card-main">
                    <div class="action-icon-main" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <div class="action-content-main">
                        <h4>Publicar Nueva Obra</h4>
                        <p>Comparte tu creación artística con la comunidad</p>
                        <span class="action-badge" style="background: #667eea;">Crear Contenido</span>
                    </div>
                </a>
                
                <a href="{{ url('/products/create') }}" class="action-card-main">
                    <div class="action-icon-main" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="action-content-main">
                        <h4>Vender Producto</h4>
                        <p>Ofrece tus artesanías u obras para la venta</p>
                        <span class="action-badge" style="background: #f093fb;">Monetizar</span>
                    </div>
                </a>
                
                <a href="{{ url('/events/create') }}" class="action-card-main">
                    <div class="action-icon-main" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    <div class="action-content-main">
                        <h4>Crear Evento</h4>
                        <p>Organiza exhibiciones o talleres</p>
                        <span class="action-badge" style="background: #4facfe;">Promocionar</span>
                    </div>
                </a>
                
                <a href="{{ url('/artist/gallery') }}" class="action-card-main">
                    <div class="action-icon-main" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                        <i class="fas fa-images"></i>
                    </div>
                    <div class="action-content-main">
                        <h4>Mi Portafolio</h4>
                        <p>Gestiona todas tus obras publicadas</p>
                        <span class="action-badge" style="background: #43e97b;">Organizar</span>
                    </div>
                </a>
            </div>
        </div>

        {{-- Contenido Reciente del Artista --}}
        <div class="artist-recent-content">
            <div class="content-tabs">
                <button class="tab-button active" data-tab="works">Mis Obras</button>
                <button class="tab-button" data-tab="products">Mis Productos</button>
                <button class="tab-button" data-tab="events">Mis Eventos</button>
            </div>
            
            {{-- Tab de Obras --}}
            <div class="tab-content active" id="works-tab">
                <div class="content-grid">
                    @php
                        $artistPosts = Auth::user()->posts ?? collect();
                    @endphp
                    
                    @forelse($artistPosts->take(6) as $post)
                    <div class="content-card">
                        <div class="card-image">
                            @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div class="image-placeholder-art">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                            <div class="card-badge">{{ $post->category->name ?? 'Arte' }}</div>
                        </div>
                        <div class="card-content">
                            <h5>{{ Str::limit($post->title, 40) }}</h5>
                            <p class="card-excerpt">{{ Str::limit($post->excerpt, 80) }}</p>
                            <div class="card-stats">
                                <span><i class="fas fa-eye"></i> {{ $post->view_count ?? 0 }}</span>
                                <span><i class="fas fa-heart"></i> {{ $post->reactions_count ?? 0 }}</span>
                                <span><i class="fas fa-comment"></i> {{ $post->comments_count ?? 0 }}</span>
                            </div>
                            <div class="card-actions">
                                <a href="{{ url('/posts/' . $post->id) }}" class="btn-small">Ver</a>
                                <a href="{{ url('/posts/' . $post->id . '/edit') }}" class="btn-small outline">Editar</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state-artist">
                        <i class="fas fa-paint-brush"></i>
                        <h4>Aún no tienes obras publicadas</h4>
                        <p>Comparte tu primera creación artística con la comunidad</p>
                        <a href="{{ url('/posts/create') }}" class="btn-primary">Crear Primera Obra</a>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Tab de Productos --}}
            <div class="tab-content" id="products-tab">
                <div class="content-grid">
                    @php
                        $artistProducts = Auth::user()->products ?? collect();
                    @endphp
                    
                    @forelse($artistProducts->take(6) as $product)
                    <div class="content-card">
                        <div class="card-image">
                            @if($product->main_image)
                                <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div class="image-placeholder-art">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                            @endif
                            <div class="product-price">${{ number_format($product->price, 0) }}</div>
                        </div>
                        <div class="card-content">
                            <h5>{{ Str::limit($product->name, 40) }}</h5>
                            <p class="card-excerpt">{{ Str::limit($product->description, 80) }}</p>
                            <div class="card-stats">
                                <span><i class="fas fa-box"></i> {{ $product->stock_quantity }} en stock</span>
                                <span><i class="fas fa-shopping-cart"></i> {{ $product->sales_count ?? 0 }} vendidos</span>
                            </div>
                            <div class="card-actions">
                                <a href="{{ url('/products/' . $product->id) }}" class="btn-small">Ver</a>
                                <a href="{{ url('/products/' . $product->id . '/edit') }}" class="btn-small outline">Editar</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state-artist">
                        <i class="fas fa-shopping-bag"></i>
                        <h4>Aún no tienes productos</h4>
                        <p>Comienza a vender tus artesanías y obras</p>
                        <a href="{{ url('/products/create') }}" class="btn-primary">Crear Primer Producto</a>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Tab de Eventos --}}
            <div class="tab-content" id="events-tab">
                <div class="content-grid">
                    @php
                        $artistEvents = Auth::user()->events ?? collect();
                    @endphp
                    
                    @forelse($artistEvents->take(6) as $event)
                    <div class="content-card">
                        <div class="card-image">
                            @if($event->post->featured_image ?? false)
                                <img src="{{ asset('storage/' . $event->post->featured_image) }}" alt="{{ $event->post->title ?? 'Evento' }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div class="image-placeholder-art">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            @endif
                            <div class="event-date">
                                {{ $event->start_date->format('d M') }}
                            </div>
                        </div>
                        <div class="card-content">
                            <h5>{{ Str::limit($event->post->title ?? 'Evento', 40) }}</h5>
                            <p class="card-excerpt">{{ $event->location->name ?? 'Ubicación por definir' }}</p>
                            <div class="card-stats">
                                <span><i class="fas fa-users"></i> {{ $event->available_slots }} cupos</span>
                                <span><i class="fas fa-{{ $event->event_type === 'free' ? 'check' : 'dollar-sign' }}"></i> {{ $event->event_type === 'free' ? 'Gratis' : '$' . number_format($event->price, 0) }}</span>
                            </div>
                            <div class="card-actions">
                                <a href="{{ url('/events/' . $event->id) }}" class="btn-small">Ver</a>
                                <a href="{{ url('/events/' . $event->id . '/edit') }}" class="btn-small outline">Editar</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state-artist">
                        <i class="fas fa-calendar-alt"></i>
                        <h4>Aún no tienes eventos</h4>
                        <p>Organiza tu primera exhibición o taller</p>
                        <a href="{{ url('/events/create') }}" class="btn-primary">Crear Primer Evento</a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// Script para tabs
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-button');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remover active de todos
            tabButtons.forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Agregar active al clickeado
            this.classList.add('active');
            const tabId = this.getAttribute('data-tab') + '-tab';
            document.getElementById(tabId).classList.add('active');
        });
    });
});
</script>
@endsection