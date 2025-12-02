@extends('layouts.app')

@section('title', 'Cultural Events - Popayán')

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/pages/events-index.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="events-page">
    <!-- Events Specific Header -->
    <section class="events-header">
        <div class="container">
            <h1><i class="fas fa-calendar-alt"></i> Cultural Events</h1>
            <p>Discover the cultural richness of Popayán</p>
        </div>
    </section>

    <!-- Filters -->
    <section class="filters-section">
        <div class="container">
            <div class="filters-grid">
                <!-- Search -->
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search events...">
                </div>

                <!-- Category Filter -->
                <div class="filter-group">
                    <label for="categoryFilter"><i class="fas fa-tags"></i> Category</label>
                    <select id="categoryFilter">
                        <option value="">All categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Location Filter -->
                <div class="filter-group">
                    <label for="locationFilter"><i class="fas fa-map-marker-alt"></i> Location</label>
                    <select id="locationFilter">
                        <option value="">All locations</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Filter -->
                <div class="filter-group">
                    <label for="dateFilter"><i class="fas fa-calendar"></i> Date</label>
                    <input type="date" id="dateFilter">
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="events-main">
        <div class="container">
            <!-- Statistics -->
            <div class="events-stats">
                <div class="stat-card">
                    <i class="fas fa-calendar-check"></i>
                    <span class="stat-number">{{ $events->total() }}</span>
                    <span class="stat-label">Active Events</span>
                </div>
                <div class="stat-card">
                    <i class="fas fa-users"></i>
                    <span class="stat-number" id="totalLocations">{{ $locations->count() }}</span>
                    <span class="stat-label">Locations</span>
                </div>
                <div class="stat-card">
                    <i class="fas fa-tags"></i>
                    <span class="stat-number">{{ $categories->count() }}</span>
                    <span class="stat-label">Categories</span>
                </div>
            </div>

            <!-- Events Grid -->
            <div class="events-grid" id="eventsGrid">
                @forelse($events as $event)
                    <div class="event-card" 
                         data-category="{{ $event->post->category_id }}"
                         data-location="{{ $event->location_id }}"
                         data-date="{{ $event->start_date->format('Y-m-d') }}"
                         data-title="{{ strtolower($event->post->title) }}">
                        <!-- Event Image -->
                        <div class="event-image">
                            @if($event->post->media->isNotEmpty())
                                <img src="{{ Storage::url($event->post->media->first()->file_path) }}" 
                                     alt="{{ $event->post->title }}">
                            @else
                                <div class="event-image-placeholder">
                                    <i class="fas fa-calendar"></i>
                                </div>
                            @endif
                            <div class="event-badge {{ $event->event_type }}">
                                {{ $event->event_type === 'free' ? 'Free' : ($event->event_type === 'paid' ? 'Paid' : 'Donation') }}
                            </div>
                        </div>

                        <!-- Event Information -->
                        <div class="event-info">
                            <h3 class="event-title">{{ $event->post->title }}</h3>
                            <p class="event-excerpt">{{ $event->post->excerpt }}</p>
                            
                            <div class="event-meta">
                                <div class="meta-item">
                                    <i class="fas fa-calendar"></i>
                                    <span>{{ $event->start_date->format('d M Y, h:i A') }}</span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $event->location->name ?? 'To be confirmed' }}</span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-user"></i>
                                    <span>{{ $event->organizer->name }}</span>
                                </div>
                            </div>

                            <div class="event-stats">
                                <span class="stat">
                                    <i class="fas fa-eye"></i> {{ $event->post->view_count }}
                                </span>
                                <span class="stat">
                                    <i class="fas fa-users"></i> {{ $event->max_capacity - $event->available_slots }}/{{ $event->max_capacity }}
                                </span>
                                <span class="stat price">
                                    @if($event->event_type === 'free')
                                        Free
                                    @else
                                        ${{ number_format($event->price, 0) }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="event-actions">
                            <a href="{{ route('events.show', $event->id) }}" class="btn-primary">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                            @auth
                                <button class="btn-secondary save-event" data-event-id="{{ $event->id }}">
                                    <i class="fas fa-bookmark"></i> Save
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="btn-secondary">
                                    <i class="fas fa-bookmark"></i> Save
                                </a>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="no-events">
                        <i class="fas fa-calendar-times"></i>
                        <h3>No events available</h3>
                        <p>New cultural events in Popayán coming soon</p>
                        @auth
                            <a href="{{ route('events.create') }}" class="btn-primary">
                                <i class="fas fa-plus"></i> Create First Event
                            </a>
                        @endauth
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($events->hasPages())
                <div class="pagination">
                    {{ $events->links() }}
                </div>
            @endif
        </div>
    </section>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/modules/events-index.js') }}"></script>
@endsection