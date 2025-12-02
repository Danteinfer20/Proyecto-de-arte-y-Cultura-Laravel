@extends('layouts.dashboard')
@section('title', 'Artist Dashboard - ' . auth()->user()->name)

@section('styles')
<!-- Load specific dashboard -->
<link href="{{ asset('css/pages/dashboard-artist.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="artist-dashboard">
    <!-- Artist Header -->
    <header class="artist-header">
        <div class="header-background"></div>
        <div class="header-content">
            <div class="artist-profile">
                <div class="profile-avatar">
                    @if(auth()->user()->profile_picture)
                        <img src="{{ Storage::url(auth()->user()->profile_picture) }}" alt="{{ auth()->user()->name }}">
                        <div class="online-status"></div>
                    @else
                        <div class="avatar-placeholder">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div class="profile-info">
                    <h1 class="artist-name">{{ auth()->user()->name }}</h1>
                    <p class="artist-bio">{{ auth()->user()->bio ?? 'Artist in Popayán' }}</p>
                    <div class="profile-stats">
                        <div class="stat">
                            <span class="stat-value">
                                @php
                                    $followers = $follower_count ?? 0;
                                    if (is_object($followers)) $followers = $followers->count();
                                    echo (int)$followers;
                                @endphp
                            </span>
                            <span class="stat-label">Followers</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">
                                @php
                                    $posts = $total_posts ?? 0;
                                    if (is_object($posts)) $posts = $posts->count();
                                    echo (int)$posts;
                                @endphp
                            </span>
                            <span class="stat-label">Works</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">
                                @php
                                    $events = $organized_events ?? 0;
                                    if (is_object($events)) $events = $events->count();
                                    echo (int)$events;
                                @endphp
                            </span>
                            <span class="stat-label">Events</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('profile.edit') }}" class="btn-edit-profile">
                    <i class="fas fa-user-edit"></i>
                    Edit Profile
                </a>
                <div class="quick-stats">
                    <div class="quick-stat">
                        <i class="fas fa-chart-line"></i>
                        <span>Revenue: ${{ number_format($total_revenue ?? 0, 0) }}</span>
                    </div>
                    <div class="quick-stat">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Sales: 
                            @php
                                $sales = $total_sales ?? 0;
                                if (is_object($sales)) $sales = $sales->count();
                                echo (int)$sales;
                            @endphp
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Metrics -->
    <section class="metrics-grid">
        <!-- Income Card -->
        <div class="metric-card income-card">
            <div class="metric-header">
                <h3>Monthly Income</h3>
                <div class="metric-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    12%
                </div>
            </div>
            <div class="metric-value">${{ number_format($total_revenue ?? 0, 0) }}</div>
            <div class="metric-chart">
                <div class="chart-bar" style="height: 60%"></div>
                <div class="chart-bar" style="height: 80%"></div>
                <div class="chart-bar" style="height: 45%"></div>
                <div class="chart-bar" style="height: 90%"></div>
                <div class="chart-bar" style="height: 70%"></div>
                <div class="chart-bar" style="height: 85%"></div>
                <div class="chart-bar" style="height: 95%"></div>
            </div>
        </div>

        <!-- Products Card -->
        <div class="metric-card products-card">
            <div class="metric-header">
                <h3>Active Products</h3>
                <div class="metric-badge">
                    @php
                        $available = $available_products ?? 0;
                        $total = $total_products ?? 0;
                        if (is_object($available)) $available = $available->count();
                        if (is_object($total)) $total = $total->count();
                        echo (int)$available . '/' . (int)$total;
                    @endphp
                </div>
            </div>
            <div class="metric-value">
                @php
                    $totalProds = $total_products ?? 0;
                    if (is_object($totalProds)) $totalProds = $totalProds->count();
                    echo (int)$totalProds;
                @endphp
            </div>
            <div class="product-stats">
                <div class="product-stat">
                    <span class="stat-dot physical"></span>
                    <span>Physical: 
                        @php
                            $physical = $physical_products ?? 0;
                            if (is_object($physical)) $physical = $physical->count();
                            echo (int)$physical;
                        @endphp
                    </span>
                </div>
                <div class="product-stat">
                    <span class="stat-dot digital"></span>
                    <span>Digital: 
                        @php
                            $digital = $digital_products ?? 0;
                            if (is_object($digital)) $digital = $digital->count();
                            echo (int)$digital;
                        @endphp
                    </span>
                </div>
            </div>
        </div>

        <!-- Engagement Card -->
        <div class="metric-card engagement-card">
            <div class="metric-header">
                <h3>Engagement</h3>
                <div class="metric-actions">
                    <button class="btn-metric">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>
            <div class="engagement-stats">
                <div class="engagement-item">
                    <i class="fas fa-eye"></i>
                    <span>
                        @php
                            $views = $total_views ?? 0;
                            if (is_object($views)) $views = $views->count();
                            echo (int)$views;
                        @endphp 
                        views
                    </span>
                </div>
                <div class="engagement-item">
                    <i class="fas fa-heart"></i>
                    <span>
                        @php
                            $reactions = $total_reactions ?? 0;
                            if (is_object($reactions)) $reactions = $reactions->count();
                            echo (int)$reactions;
                        @endphp 
                        reactions
                    </span>
                </div>
                <div class="engagement-item">
                    <i class="fas fa-comment"></i>
                    <span>
                        @php
                            $comments = $total_comments ?? 0;
                            if (is_object($comments)) $comments = $comments->count();
                            echo (int)$comments;
                        @endphp 
                        comments
                    </span>
                </div>
            </div>
        </div>

        <!-- Upcoming Events Card -->
        <div class="metric-card events-card">
            <div class="metric-header">
                <h3>Upcoming Events</h3>
                <span class="events-count">
                    @php
                        $upcoming = $upcoming_events ?? 0;
                        if (is_object($upcoming)) $upcoming = $upcoming->count();
                        echo (int)$upcoming;
                    @endphp
                </span>
            </div>
            @php
                $upcomingCount = $upcoming_events ?? 0;
                if (is_object($upcomingCount)) $upcomingCount = $upcomingCount->count();
            @endphp
            
            @if($upcomingCount > 0 && isset($recent_events) && $recent_events->count() > 0)
            <div class="next-event">
                <div class="event-date">
                    <span class="event-day">{{ $recent_events->first()->start_date->format('d') }}</span>
                    <span class="event-month">{{ $recent_events->first()->start_date->format('M') }}</span>
                </div>
                <div class="event-info">
                    <h4>{{ $recent_events->first()->post->title ?? 'Event' }}</h4>
                    <p>{{ $recent_events->first()->location->name ?? 'Location to be confirmed' }} • {{ $recent_events->first()->start_date->format('H:i') }}</p>
                </div>
            </div>
            @else
            <div class="no-events">
                <i class="fas fa-calendar-plus"></i>
                <p>No upcoming events</p>
                <a href="{{ route('events.create') }}" class="btn-create-event">Create Event</a>
            </div>
            @endif
        </div>
    </section>

    <!-- Main Content Section -->
    <section class="main-content">
        <!-- Recent Works -->
        <div class="content-section">
            <div class="section-header">
                <h2>My Recent Works</h2>
                <a href="{{ route('posts.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i>
                    New Work
                </a>
            </div>
            <div class="artworks-grid">
                @forelse($recent_posts ?? [] as $post)
                <div class="artwork-card">
                    <div class="artwork-image">
                        @if($post->media->first())
                            <img src="{{ Storage::url($post->media->first()->file_path) }}" alt="{{ $post->title }}">
                        @else
                            <div class="artwork-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif
                        <div class="artwork-overlay">
                            <div class="artwork-stats">
                                <span><i class="fas fa-eye"></i> {{ $post->view_count ?? 0 }}</span>
                                <span><i class="fas fa-heart"></i> {{ $post->reactions_count ?? 0 }}</span>
                            </div>
                            <div class="artwork-actions">
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn-action">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn-action">
                                    <i class="fas fa-chart-bar"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="artwork-info">
                        <h4>{{ Str::limit($post->title, 30) }}</h4>
                        <p>{{ $post->category->name ?? 'No category' }}</p>
                        <span class="artwork-date">{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <i class="fas fa-palette"></i>
                    <h3>No works published</h3>
                    <p>Start by sharing your first artwork</p>
                    <a href="{{ route('posts.create') }}" class="btn-primary">Create First Work</a>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Featured Products -->
        <div class="content-section">
            <div class="section-header">
                <h2>Products for Sale</h2>
                <a href="{{ route('products.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i>
                    New Product
                </a>
            </div>
            <div class="products-grid">
                @forelse($recent_products ?? [] as $product)
                <div class="product-card">
                    <div class="product-image">
                        @if($product->main_image)
                            <img src="{{ Storage::url($product->main_image) }}" alt="{{ $product->name }}">
                        @else
                            <div class="product-placeholder">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                        @endif
                        <div class="product-badge {{ $product->status ?? 'available' }}">
                            {{ ($product->status ?? 'available') === 'available' ? 'Available' : 'Sold Out' }}
                        </div>
                    </div>
                    <div class="product-info">
                        <h4>{{ Str::limit($product->name, 25) }}</h4>
                        <p class="product-price">${{ number_format($product->price ?? 0, 0) }}</p>
                        <div class="product-meta">
                            <span><i class="fas fa-shopping-cart"></i> {{ $product->sales_count ?? 0 }} sold</span>
                            <span><i class="fas fa-box"></i> {{ $product->stock_quantity ?? 0 }} in stock</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <i class="fas fa-store"></i>
                    <h3>No products for sale</h3>
                    <p>Start selling your works and products</p>
                    <a href="{{ route('products.create') }}" class="btn-primary">Add Product</a>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions-section">
            <h2>Quick Actions</h2>
            <div class="actions-grid">
                <a href="{{ route('posts.create') }}" class="action-card">
                    <div class="action-icon primary">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <h4>Publish Work</h4>
                    <p>Share your new creation</p>
                </a>
                
                <a href="{{ route('products.create') }}" class="action-card">
                    <div class="action-icon success">
                        <i class="fas fa-store"></i>
                    </div>
                    <h4>Sell Product</h4>
                    <p>Add a product to your store</p>
                </a>
                
                <a href="{{ route('events.create') }}" class="action-card">
                    <div class="action-icon warning">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    <h4>Organize Event</h4>
                    <p>Create a cultural event</p>
                </a>
                
                <a href="{{ route('artist.gallery') }}" class="action-card">
                    <div class="action-icon info">
                        <i class="fas fa-images"></i>
                    </div>
                    <h4>My Gallery</h4>
                    <p>Manage all your works</p>
                </a>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Counter animation
    const counters = document.querySelectorAll('.stat-value');
    counters.forEach(counter => {
        const target = parseInt(counter.textContent) || 0;
        let current = 0;
        const increment = target / 30;
        
        const updateCounter = () => {
            if (current < target) {
                current += increment;
                counter.textContent = Math.ceil(current);
                setTimeout(updateCounter, 40);
            } else {
                counter.textContent = target;
            }
        };
        
        updateCounter();
    });

    // Hover effects on artwork cards
    const artworkCards = document.querySelectorAll('.artwork-card');
    artworkCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Animated mini chart
    const chartBars = document.querySelectorAll('.chart-bar');
    chartBars.forEach((bar, index) => {
        setTimeout(() => {
            bar.style.opacity = '1';
        }, index * 100);
    });

    // Update metrics in real time
    const refreshBtn = document.querySelector('.btn-metric');
    if (refreshBtn) {
        refreshBtn.addEventListener('click', function() {
            this.classList.add('refreshing');
            setTimeout(() => {
                this.classList.remove('refreshing');
                // AJAX call to update metrics would go here
            }, 1000);
        });
    }
});
</script>
@endsection