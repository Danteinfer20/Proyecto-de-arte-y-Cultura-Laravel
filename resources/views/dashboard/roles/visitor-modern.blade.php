@extends('layouts.dashboard')

@section('title', 'Visitor Dashboard - ' . auth()->user()->name)

@section('styles')
<!-- VISITOR SPECIFIC CSS ONLY - REMOVE OTHERS -->
<link href="{{ asset('css/pages/dashboard-visitor.css') }}" rel="stylesheet">

<!-- FONT AWESOME -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<!-- INLINE TEST CSS -->


@section('content')
<div class="visitor-dashboard">
    <!-- Visitor Header -->
    <header class="visitor-header">
        <div class="header-background"></div>
        <div class="header-content">
            <div class="visitor-profile">
                <div class="profile-avatar">
                    @if(auth()->user()->profile_picture)
                        <img src="{{ Storage::url(auth()->user()->profile_picture) }}" alt="{{ auth()->user()->name }}">
                    @else
                        <div class="avatar-placeholder">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div class="profile-info">
                    <h1 class="visitor-name">{{ auth()->user()->name }}</h1>
                    <p class="visitor-bio">{{ auth()->user()->bio ?? 'Art and culture lover in Popayán' }}</p>
                    <div class="profile-stats">
                        <div class="stat">
                            <span class="stat-value">{{ $following_count ?? 0 }}</span>
                            <span class="stat-label">Following</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">{{ $follower_count ?? 0 }}</span>
                            <span class="stat-label">Followers</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">{{ $saved_posts ?? 0 }}</span>
                            <span class="stat-label">Saved</span>
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
                        <i class="fas fa-calendar-check"></i>
                        <span>Events attended: {{ $events_attended ?? 0 }}</span>
                    </div>
                    <div class="quick-stat">
                        <i class="fas fa-comment"></i>
                        <span>Comments: {{ $comments_made ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Metrics -->
    <section class="metrics-grid">
        <!-- Saved Content Card -->
        <div class="metric-card saved-card">
            <div class="metric-header">
                <h3><i class="fas fa-bookmark"></i> Saved Content</h3>
                <div class="metric-badge">
                    {{ $saved_posts ?? 0 }} items
                </div>
            </div>
            <div class="metric-value">{{ $saved_posts ?? 0 }}</div>
            <div class="saved-stats">
                <div class="saved-stat">
                    <i class="fas fa-star"></i>
                    <span>Favorites: {{ $favorite_posts ?? 0 }}</span>
                </div>
                <div class="saved-stat">
                    <i class="fas fa-lightbulb"></i>
                    <span>Inspiration: {{ $inspiration_posts ?? 0 }}</span>
                </div>
            </div>
        </div>

        <!-- Events Card -->
        <div class="metric-card events-card">
            <div class="metric-header">
                <h3><i class="fas fa-calendar-alt"></i> Participation</h3>
                <div class="metric-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    Active
                </div>
            </div>
            <div class="metric-value">{{ $events_interested ?? 0 }}</div>
            <div class="events-stats">
                <div class="event-stat">
                    <i class="fas fa-check-circle"></i>
                    <span>Attended: {{ $events_attended ?? 0 }}</span>
                </div>
                <div class="event-stat">
                    <i class="fas fa-clock"></i>
                    <span>Interested: {{ $events_interested ?? 0 }}</span>
                </div>
            </div>
        </div>

        <!-- Social Card -->
        <div class="metric-card social-card">
            <div class="metric-header">
                <h3><i class="fas fa-users"></i> Community</h3>
                <div class="metric-badge">
                    Connected
                </div>
            </div>
            <div class="social-stats">
                <div class="social-item">
                    <i class="fas fa-user-plus"></i>
                    <div class="social-info">
                        <span class="social-value">{{ $following_count ?? 0 }}</span>
                        <span class="social-label">Following</span>
                    </div>
                </div>
                <div class="social-item">
                    <i class="fas fa-users"></i>
                    <div class="social-info">
                        <span class="social-value">{{ $follower_count ?? 0 }}</span>
                        <span class="social-label">Followers</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Discovery Card -->
        <div class="metric-card discovery-card">
            <div class="metric-header">
                <h3><i class="fas fa-compass"></i> Discovery</h3>
                <div class="metric-actions">
                    <button class="btn-metric">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>
            <div class="discovery-content">
                <p>Explore new content</p>
                <a href="{{ route('events.index') }}" class="btn-discovery">
                    <i class="fas fa-search"></i>
                    Discover Events
                </a>
                <a href="{{ route('posts.index') }}" class="btn-discovery">
                    <i class="fas fa-newspaper"></i>
                    View Posts
                </a>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="main-content">
        <!-- Saved Content -->
        <div class="content-section">
            <div class="section-header">
                <h2>Your Saved Content</h2>
                <a href="#" class="btn-primary">
                    <i class="fas fa-bookmark"></i>
                    View All
                </a>
            </div>
            
            @if($saved_posts_list && $saved_posts_list->count() > 0)
            <div class="saved-grid">
                @foreach($saved_posts_list as $savedItem)
                @php $post = $savedItem->post; @endphp
                @if($post)
                <div class="saved-card">
                    <div class="saved-image">
                        @if($post->media->first())
                            <img src="{{ Storage::url($post->media->first()->file_path) }}" alt="{{ $post->title }}">
                        @else
                            <div class="saved-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif
                        <div class="saved-category {{ $savedItem->category ?? 'favorites' }}">
                            {{ $savedItem->category ?? 'Favorite' }}
                        </div>
                    </div>
                    <div class="saved-info">
                        <h4>{{ Str::limit($post->title, 30) }}</h4>
                        <p class="saved-author">
                            By {{ $post->user->name }}
                        </p>
                        <div class="saved-meta">
                            <span><i class="fas fa-eye"></i> {{ $post->view_count ?? 0 }}</span>
                            <span><i class="fas fa-heart"></i> {{ $post->reactions_count ?? 0 }}</span>
                        </div>
                    </div>
                    <div class="saved-actions">
                        <a href="{{ route('posts.show', $post) }}" class="btn-action">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button class="btn-action" onclick="unsavePost({{ $savedItem->id }})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            @else
            <div class="empty-state">
                <i class="fas fa-bookmark"></i>
                <h3>No saved content</h3>
                <p>Start exploring and save content that interests you</p>
                <div class="empty-actions">
                    <a href="{{ route('posts.index') }}" class="btn-primary">Explore Posts</a>
                    <a href="{{ route('events.index') }}" class="btn-secondary">View Events</a>
                </div>
            </div>
            @endif
        </div>

        <!-- Upcoming Events -->
        <div class="content-section">
            <div class="section-header">
                <h2>Upcoming Events</h2>
                <a href="{{ route('events.index') }}" class="btn-primary">
                    <i class="fas fa-calendar"></i>
                    View All
                </a>
            </div>
            
            @if($upcoming_events && $upcoming_events->count() > 0)
            <div class="events-grid">
                @foreach($upcoming_events as $event)
                <div class="event-card">
                    <div class="event-header">
                        <div class="event-date">
                            <span class="event-day">{{ $event->start_date->format('d') }}</span>
                            <span class="event-month">{{ $event->start_date->format('M') }}</span>
                        </div>
                        <div class="event-title">
                            <h4>{{ $event->post->title ?? 'Event' }}</h4>
                            <p>{{ $event->location->name ?? 'Location to be confirmed' }}</p>
                        </div>
                    </div>
                    <div class="event-info">
                        <div class="event-time">
                            <i class="fas fa-clock"></i>
                            {{ $event->start_date->format('H:i') }}
                        </div>
                        <div class="event-type">
                            <span class="event-badge {{ $event->event_type ?? 'free' }}">
                                {{ $event->event_type === 'free' ? 'Free' : 'Paid' }}
                            </span>
                        </div>
                    </div>
                    <div class="event-actions">
                        <a href="{{ route('events.show', $event) }}" class="btn-primary btn-sm">
                            View Details
                        </a>
                        <button class="btn-secondary btn-sm" onclick="markInterested({{ $event->id }})">
                            Interested
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="empty-state">
                <i class="fas fa-calendar-plus"></i>
                <h3>No upcoming events</h3>
                <p>Discover cultural events in Popayán</p>
                <a href="{{ route('events.index') }}" class="btn-primary">Explore Events</a>
            </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions-section">
            <h2>Explore and Discover</h2>
            <div class="actions-grid">
                <a href="{{ route('events.index') }}" class="action-card">
                    <div class="action-icon primary">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h4>Events</h4>
                    <p>Discover cultural events</p>
                </a>
                
                <a href="{{ route('posts.index') }}" class="action-card">
                    <div class="action-icon success">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <h4>Posts</h4>
                    <p>Read interesting content</p>
                </a>
                
                <a href="{{ route('products.index') }}" class="action-card">
                    <div class="action-icon warning">
                        <i class="fas fa-palette"></i>
                    </div>
                    <h4>Art</h4>
                    <p>Admire works and products</p>
                </a>
                
                <a href="{{ route('users.index') }}" class="action-card">
                    <div class="action-icon info">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4>Artists</h4>
                    <p>Meet the creators</p>
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

    // Hover effects on cards
    const cards = document.querySelectorAll('.saved-card, .event-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});

function unsavePost(savedItemId) {
    if (confirm('Are you sure you want to remove this content from saved?')) {
        // AJAX call to delete would go here
        console.log('Removing saved content:', savedItemId);
    }
}

function markInterested(eventId) {
    // AJAX call to mark interest would go here
    console.log('Marking interest in event:', eventId);
}
</script>
@endsection