@extends('layouts.app')

@section('title', 'Inicio - Arte & Cultura Popayán')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-content">
        <h1 class="hero-title">Bienvenido a la Cultura de Popayán</h1>
        <p class="hero-subtitle">Descubre el arte, los eventos y la tradición de la Ciudad Blanca</p>
        <div class="hero-buttons">
            <a href="{{ url('/events') }}" class="btn btn-primary">Explorar Eventos</a>
            <a href="{{ url('/register') }}" class="btn btn-secondary">Unirse a la Comunidad</a>
        </div>
    </div>
</section>

<!-- Eventos Destacados -->
<section class="home-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Eventos Destacados</h2>
            <p class="section-subtitle">Participa en los eventos culturales más importantes de Popayán</p>
        </div>
        <div class="events-grid">
            @foreach($featuredEvents as $event)
            <div class="card event-card fade-in">
                <div class="card-image">
                    @include('icons.calendar')
                </div>
                <div class="card-content">
                    <div class="card-header">
                        <h3 class="card-title">{{ $event->post->title }}</h3>
                        @if($event->event_type === 'free')
                        <span class="card-category">Gratis</span>
                        @endif
                    </div>
                    <div class="event-date">
                        @include('icons.clock')
                        <span>{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y - h:i A') }}</span>
                    </div>
                    <div class="event-location">
                        @include('icons.location')
                        <span>{{ $event->location->name }}</span>
                    </div>
                    <div class="event-price {{ $event->event_type === 'free' ? 'free' : '' }}">
                        {{ $event->event_type === 'free' ? 'Gratis' : '$' . number_format($event->price, 0) }}
                    </div>
                    <a href="{{ url('/events/' . $event->id) }}" class="btn btn-primary btn-small">Ver Detalles</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Productos Populares -->
<section class="home-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Productos Artesanales</h2>
            <p class="section-subtitle">Descubre la artesanía y arte local de Popayán</p>
        </div>
        <div class="products-grid">
            @foreach($featuredProducts as $product)
            <div class="card product-card fade-in">
                @if($product->is_featured)
                <div class="featured-badge">Destacado</div>
                @endif
                <div class="card-image">
                    @include('icons.art')
                </div>
                <div class="card-content">
                    <h3 class="card-title">{{ $product->name }}</h3>
                    <span class="card-category">{{ $product->category->name }}</span>
                    <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
                    <div class="product-price">
                        @if($product->sale_price)
                        <span class="current-price">${{ number_format($product->sale_price, 0) }}</span>
                        <span class="original-price">${{ number_format($product->price, 0) }}</span>
                        @else
                        <span class="current-price">${{ number_format($product->price, 0) }}</span>
                        @endif
                    </div>
                    <div class="product-meta">
                        <span class="stock-badge">{{ $product->stock_quantity }} disponibles</span>
                        <a href="{{ url('/products/' . $product->id) }}" class="btn btn-primary btn-small">Comprar</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Categorías -->
<section class="home-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Explora Categorías</h2>
            <p class="section-subtitle">Descubre todos los aspectos de la cultura payanesa</p>
        </div>
        <div class="categories-grid">
            @foreach($categories as $category)
            <div class="card category-card fade-in">
                <div class="category-icon">{!! $category->icon !!}</div>
                <h3 class="category-name">{{ $category->name }}</h3>
                <p class="category-count">{{ $category->posts_count + $category->products_count }} elementos</p>
                <a href="{{ url('/categories/' . $category->id) }}" class="btn btn-secondary btn-small mt-sm">Explorar</a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">{{ $stats['total_events'] }}+</div>
                <div class="stat-label">Eventos Culturales</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $stats['total_products'] }}+</div>
                <div class="stat-label">Productos Artesanales</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $stats['total_posts'] }}+</div>
                <div class="stat-label">Artículos Culturales</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">¿Eres Artista o Creador?</h2>
            <p>Únete a nuestra comunidad y comparte tu talento con el mundo</p>
            <div class="cta-buttons">
                <a href="{{ url('/register') }}" class="btn btn-primary btn-large">Registrarse</a>
                <a href="{{ url('/about') }}" class="btn btn-secondary btn-large">Saber Más</a>
            </div>
        </div>
    </div>
</section>
@endsection