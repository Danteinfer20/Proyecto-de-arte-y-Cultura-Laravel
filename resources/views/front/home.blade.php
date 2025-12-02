@extends('layouts.app')

@section('title', 'Art and Culture Popayán - Home')

@section('css')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')
<!-- HERO SECTION -->
<section class="hero">
    <div class="hero-background">
        <img src="https://i.pinimg.com/1200x/b2/8c/60/b28c60f717046ce5576a653faf5c3561.jpg" alt="Popayán Culture">
        <div class="hero-overlay"></div>
    </div>
    <div class="hero-content">
        <h1>Discover the Cultural Magic of Popayán</h1>
        <p>Explore unique events, talented artists and authentic crafts in the heart of Cauca</p>
        <div class="hero-buttons">
            <a href="{{ route('events.index') }}" class="btn btn-primary">View Events</a>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Buy Crafts</a>
        </div>
    </div>
</section>

<!-- FEATURED SECTIONS -->
<div class="container">
    <!-- EVENTS -->
    <section class="featured-section">
        <div class="section-header">
            <h2>Upcoming Events</h2>
            <a href="{{ route('events.index') }}" class="view-all">View all</a>
        </div>
        <div class="cards-grid">
            @foreach($featuredEvents->take(3) as $event)
            <div class="card">
                <div class="card-image">
                    <img src="https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="{{ $event->post->title }}">
                    <div class="card-badge">Event</div>
                </div>
                <div class="card-content">
                    <h3>{{ $event->post->title }}</h3>
                    <p class="card-meta">
                        <span class="date">{{ $event->start_date->format('d M') }}</span>
                        @if($event->location)
                        <span class="location">{{ $event->location->name }}</span>
                        @endif
                    </p>
                    <p class="card-description">{{ Str::limit($event->post->excerpt, 90) }}</p>
                    <a href="{{ route('events.show', $event->id) }}" class="card-link">More info</a>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- PRODUCTS -->
    <section class="featured-section">
        <div class="section-header">
            <h2>Featured Crafts</h2>
            <a href="{{ route('products.index') }}" class="view-all">View all</a>
        </div>
        <div class="cards-grid">
            @foreach($featuredProducts->take(3) as $product)
            <div class="card">
                <div class="card-image">
                    <img src="https://images.unsplash.com/photo-1566150905458-1bf1fc113f0d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="{{ $product->name }}">
                    <div class="card-badge">Craft</div>
                </div>
                <div class="card-content">
                    <h3>{{ $product->name }}</h3>
                    <p class="card-price">${{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="card-description">{{ Str::limit($product->description, 80) }}</p>
                    <div class="card-footer">
                        <span class="artist">By {{ $product->user->name }}</span>
                        <a href="#" class="card-link">Buy</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- ARTISTS -->
    <section class="featured-section">
        <div class="section-header">
            <h2>Featured Artists</h2>
            <a href="#" class="view-all">View all</a>
        </div>
        <div class="artists-grid">
            @foreach($featuredArtists->take(3) as $artist)
            <div class="artist-card">
                <div class="artist-avatar">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="{{ $artist->name }}">
                </div>
                <div class="artist-info">
                    <h3>{{ $artist->name }}</h3>
                    <p class="artist-specialty">{{ $artist->user_type === 'artist' ? 'Visual Artist' : 'Cultural Manager' }}</p>
                    <p class="artist-bio">{{ Str::limit($artist->bio, 100) }}</p>
                    <a href="#" class="artist-link">View profile</a>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>
@endsection