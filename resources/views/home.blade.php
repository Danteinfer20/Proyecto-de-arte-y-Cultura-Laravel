@extends('layouts.app')

@section('title', 'Arte y Cultura Popayán - Inicio')
@section('description', 'Descubre la riqueza cultural, eventos y artistas de Popayán')

@section('css')
<link rel="stylesheet" href="{{ asset('css/components/cards.css') }}">
<link rel="stylesheet" href="{{ asset('css/pages/home.css') }}">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
@endsection

@section('content')
<!-- HERO PARALLAX -->
<section class="hero-parallax">
    <div class="parallax-bg" style="background-image: url('https://i.pinimg.com/1200x/17/d6/9f/17d69f8fae014ee87261ecb20a4702c2.jpg')"></div>
    <div class="hero-content">
        <div class="hero-text">
            <h1 class="hero-title" data-aos="fade-up">
                <span class="title-line">Descubre el Alma</span>
                <span class="title-line accent">Cultural de Popayán</span>
            </h1>
            <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="200">
                Donde el arte, la tradición y la creatividad se encuentran en la Ciudad Blanca
            </p>
            <div class="hero-actions" data-aos="fade-up" data-aos-delay="400">
                <a href="{{ route('events.index') }}" class="btn btn-primary">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Explorar Eventos</span>
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Ver Artesanías</span>
                </a>
            </div>
        </div>
        <div class="hero-stats" data-aos="fade-up" data-aos-delay="600">
            <div class="stat-item">
                <div class="stat-number" data-count="{{ $stats['events_count'] }}">0</div>
                <div class="stat-label">Eventos Activos</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-count="{{ $stats['artists_count'] }}">0</div>
                <div class="stat-label">Artistas</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-count="{{ $stats['products_count'] }}">0</div>
                <div class="stat-label">Artesanías</div>
            </div>
        </div>
    </div>
    <div class="scroll-indicator">
        <div class="scroll-arrow"></div>
    </div>
</section>

<!-- CATEGORÍAS -->
<section class="section categories-section" id="categories">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Explora por Categoría</h2>
        <div class="categories-grid">
            @foreach($categories as $category)
            <div class="card category-card" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="category-icon">
                    <i class="fas {{ $category->icon ?? 'fa-star' }}"></i>
                </div>
                <h3 class="category-name">{{ $category->name }}</h3>
                <p class="category-count">
                    {{ $category->posts_count + $category->products_count + $category->events_count }} contenidos
                </p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- EVENTOS DESTACADOS -->
<section class="section featured-events-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title" data-aos="fade-up">Eventos Destacados</h2>
            <a href="{{ route('events.index') }}" class="section-link">
                Ver Todos <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="cards-grid">
            @foreach($featuredEvents as $event)
            <div class="card event-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card-image">
                    <img src="https://i.pinimg.com/736x/8b/da/e2/8bdae2dd5c31e92dac85247efbcec509.jpg" 
                         alt="{{ $event->post->title ?? 'Evento' }}">
                </div>
                <div class="card-content">
                    <div class="card-header">
                        <h3 class="card-title">{{ $event->post->title ?? 'Evento Cultural' }}</h3>
                        <span class="card-category">{{ $event->post->category->name ?? 'Cultural' }}</span>
                    </div>
                    
                    <div class="event-date">
                        <i class="fas fa-calendar"></i>
                        {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y - h:i A') }}
                    </div>
                    
                    <div class="event-location">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $event->location->name ?? 'Popayán' }}
                    </div>
                    
                    <div class="event-price {{ $event->price == 0 ? 'free' : '' }}">
                        @if($event->price > 0)
                        ${{ number_format($event->price) }}
                        @else
                        Gratuito
                        @endif
                    </div>
                    
                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-outline">Ver Detalles</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- PRODUCTOS DESTACADOS -->
<section class="section featured-products-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title" data-aos="fade-up">Artesanías Destacadas</h2>
            <a href="{{ route('products.index') }}" class="section-link">
                Ver Tienda <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="cards-grid">
            @foreach($featuredProducts as $product)
            <div class="card product-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card-image">
                    <img src="{{ $product->main_image ? asset('storage/' . $product->main_image) : 'https://i.pinimg.com/736x/48/b1/9c/48b19cbac47db10be6e71d1fe4849b9a.jpg' }}" 
                         alt="{{ $product->name }}">
                </div>
                <div class="card-content">
                    <div class="card-header">
                        <h3 class="card-title">{{ $product->name }}</h3>
                        <span class="card-category">{{ $product->category->name ?? 'Artesanía' }}</span>
                    </div>
                    
                    <p class="product-description">
                        {{ Str::limit($product->description, 100) }}
                    </p>
                    
                    <div class="product-price">
                        @if($product->sale_price)
                        <span class="current-price">${{ number_format($product->sale_price) }}</span>
                        <span class="original-price">${{ number_format($product->price) }}</span>
                        @else
                        <span class="current-price">${{ number_format($product->price) }}</span>
                        @endif
                    </div>
                    
                    <div class="product-meta">
                        <span class="stock-badge {{ $product->stock_quantity > 10 ? 'in-stock' : 'low-stock' }}">
                            {{ $product->stock_quantity }} disponibles
                        </span>
                        <button class="btn-cart" data-product-id="{{ $product->id }}">
                            <i class="fas fa-shopping-cart"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ARTISTAS DESTACADOS -->
<section class="section artists-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title" data-aos="fade-up">Nuestros Artistas</h2>
            <a href="{{ route('dashboard.artist') }}" class="section-link">
                Ver Todos <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="artists-grid">
            @foreach($featuredArtists as $artist)
            <div class="card artist-card" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="artist-avatar">
                    <img src="{{ $artist->profile_picture ? asset('storage/' . $artist->profile_picture) : 'https://i.pinimg.com/736x/fd/21/f9/fd21f986f7a20d0c8829ae4ccd2f2951.jpg' }}" 
                         alt="{{ $artist->name }}">
                </div>
                <div class="artist-info">
                    <h3 class="artist-name">{{ $artist->name }}</h3>
                    <p class="artist-bio">{{ Str::limit($artist->bio, 80) }}</p>
                    <div class="artist-stats">
                        <span class="stat">
                            <i class="fas fa-palette"></i>
                            {{ $artist->products_count }} obras
                        </span>
                    </div>
                    <a href="{{ route('dashboard.artist') }}" class="btn btn-outline">Ver Portfolio</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- NEWSLETTER -->
<section class="newsletter-section">
    <div class="container">
        <div class="newsletter-content" data-aos="fade-up">
            <h2>Mantente Conectado</h2>
            <p>Recibe las últimas noticias sobre eventos y actividades culturales en Popayán</p>
            <form class="newsletter-form">
                <div class="input-group">
                    <input type="email" placeholder="Tu correo electrónico" required>
                    <button type="submit" class="btn-newsletter">
                        <span>Suscribirse</span>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS
    AOS.init({
        duration: 800,
        once: true,
        offset: 100
    });

    // Counter animation for stats
    const counters = document.querySelectorAll('.stat-number');
    counters.forEach(counter => {
        const target = +counter.getAttribute('data-count');
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;
        
        const updateCounter = () => {
            current += step;
            if (current < target) {
                counter.textContent = Math.ceil(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };
        updateCounter();
    });

    // Scroll indicator
    const scrollIndicator = document.querySelector('.scroll-indicator');
    scrollIndicator.addEventListener('click', () => {
        document.querySelector('#categories').scrollIntoView({
            behavior: 'smooth'
        });
    });

    // Add to cart functionality
    document.querySelectorAll('.btn-cart').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            // Add cart logic here
            this.innerHTML = '<i class="fas fa-check"></i>';
            this.style.background = 'var(--color-exito)';
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-shopping-cart"></i>';
                this.style.background = 'var(--color-azul)';
            }, 2000);
        });
    });

    // Parallax effect
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const parallax = document.querySelector('.parallax-bg');
        if (parallax) {
            parallax.style.transform = `translateY(${scrolled * 0.5}px)`;
        }
    });
});
</script>
@endsection