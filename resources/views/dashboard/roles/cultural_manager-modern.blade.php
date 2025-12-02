@extends('layouts.dashboard')

@section('title', 'Cultural Manager Dashboard - ' . auth()->user()->name)

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link href="{{ asset('css/pages/dashboard-manager.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="manager-dashboard">
    <!-- Cultural Manager Header -->
    <header class="manager-hero">
        <div class="hero-background-manager">
            <div class="manager-hero-pattern"></div>
        </div>
        <div class="hero-content-manager">
            <div class="manager-intro">
                <h2><i class="fas fa-calendar-star"></i> Cultural Management</h2>
                <p>Coordinate and promote the culture of Popayán</p>
            </div>
            <div class="manager-quick-stats">
                <div class="manager-stat-badge primary">
                    <span class="stat-number">{{ $total_events ?? 0 }}</span>
                    <span class="stat-label">My Events</span>
                </div>
                <div class="manager-stat-badge success">
                    <span class="stat-number">{{ $upcoming_events ?? 0 }}</span>
                    <span class="stat-label">Upcoming</span>
                </div>
                <div class="manager-stat-badge info">
                    <span class="stat-number">{{ $total_attendees ?? 0 }}</span>
                    <span class="stat-label">Total Attendees</span>
                </div>
                <div class="manager-stat-badge warning">
                    <span class="stat-number">{{ $past_events ?? 0 }}</span>
                    <span class="stat-label">Past Events</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Cultural Management Overview -->
    <div class="manager-overview-dashboard">
        <div class="overview-header">
            <h3><i class="fas fa-chart-pie"></i> Management Overview</h3>
            <div class="overview-period">
                <select class="period-select-manager">
                    <option value="month">This Month</option>
                    <option value="quarter">This Quarter</option>
                    <option value="year">This Year</option>
                </select>
            </div>
        </div>

        <div class="overview-grid-manager">
            <!-- Metric: Participation -->
            <div class="overview-card engagement" data-aos="fade-up">
                <div class="overview-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="overview-content">
                    <div class="overview-value">{{ $total_attendees ?? 0 }}</div>
                    <div class="overview-label">Total Participation</div>
                    <div class="overview-trend positive">
                        <i class="fas fa-arrow-up"></i>
                        25% more than last month
                    </div>
                </div>
            </div>

            <!-- Metric: Scheduled Events -->
            <div class="overview-card scheduled" data-aos="fade-up" data-aos-delay="100">
                <div class="overview-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="overview-content">
                    <div class="overview-value">{{ $upcoming_events ?? 0 }}</div>
                    <div class="overview-label">Scheduled Events</div>
                    <div class="overview-trend positive">
                        <i class="fas fa-arrow-up"></i>
                        3 new this month
                    </div>
                </div>
            </div>

            <!-- Metric: Venues Used -->
            <div class="overview-card venues" data-aos="fade-up" data-aos-delay="200">
                <div class="overview-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="overview-content">
                    <div class="overview-value">{{ $locations_used ? $locations_used->count() : 0 }}</div>
                    <div class="overview-label">Cultural Venues</div>
                    <div class="overview-trend stable">
                        <i class="fas fa-minus"></i>
                        Same as previous month
                    </div>
                </div>
            </div>

            <!-- Metric: Satisfaction -->
            <div class="overview-card satisfaction" data-aos="fade-up" data-aos-delay="300">
                <div class="overview-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="overview-content">
                    <div class="overview-value">{{ $average_attendance ?? 0 }}</div>
                    <div class="overview-label">Average Attendance</div>
                    <div class="overview-trend positive">
                        <i class="fas fa-arrow-up"></i>
                        +0.2 points
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Management -->
    <div class="manager-events-section">
        <div class="section-header-manager">
            <h3><i class="fas fa-calendar-alt"></i> My Cultural Events</h3>
            <div class="events-filter">
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="upcoming">Upcoming</button>
                <button class="filter-btn" data-filter="past">Past</button>
            </div>
        </div>

        <div class="events-management-grid">
            <!-- Event List -->
            <div class="events-list-container" data-aos="fade-up">
                <div class="events-list-header">
                    <h4>Event List</h4>
                    <a href="{{ route('events.create') }}" class="btn-create-event">
                        <i class="fas fa-plus"></i>
                        New Event
                    </a>
                </div>

                <div class="events-scrollable-list">
                    @forelse($recent_events ?? [] as $event)
                    <div class="event-list-item" data-event-id="{{ $event->id }}" data-status="{{ $event->start_date->isFuture() ? 'upcoming' : 'past' }}">
                        <div class="event-list-main">
                            <div class="event-date-badge">
                                <div class="event-day">{{ $event->start_date->format('d') }}</div>
                                <div class="event-month">{{ $event->start_date->format('M') }}</div>
                            </div>
                            <div class="event-list-info">
                                <h5 class="event-list-title">{{ $event->post->title ?? 'Event' }}</h5>
                                <div class="event-list-meta">
                                    <span class="event-location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ $event->location->name ?? 'To be defined' }}
                                    </span>
                                    <span class="event-time">
                                        <i class="fas fa-clock"></i>
                                        {{ $event->start_date->format('h:i A') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="event-list-stats">
                            <div class="event-stat">
                                <i class="fas fa-users"></i>
                                <span>{{ $event->available_slots ?? 0 }} slots</span>
                            </div>
                            <div class="event-stat">
                                <i class="fas fa-{{ $event->event_type === 'free' ? 'check' : 'ticket-alt' }}"></i>
                                <span>{{ $event->event_type === 'free' ? 'Free' : '$' . number_format($event->price ?? 0, 0) }}</span>
                            </div>
                        </div>
                        <div class="event-list-actions">
                            <a href="{{ route('events.edit', $event) }}" class="action-btn quick-edit" title="Edit event">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('events.show', $event) }}" class="action-btn view-details" title="View details">
                                <i class="fas fa-eye"></i>
                            </a>
                            <div class="event-status-indicator {{ $event->start_date->isFuture() ? 'upcoming' : 'past' }}">
                                {{ $event->start_date->isFuture() ? 'Upcoming' : 'Finished' }}
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-events-list">
                        <i class="fas fa-calendar-plus"></i>
                        <h5>No events created</h5>
                        <p>Start by organizing your first cultural event</p>
                        <a href="{{ route('events.create') }}" class="btn-create-first">
                            <i class="fas fa-plus"></i>
                            Create First Event
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Selected Event Details -->
            <div class="event-details-container" data-aos="fade-up" data-aos-delay="100">
                <div class="event-details-header">
                    <h4>Event Details</h4>
                    <div class="event-details-actions">
                        <button class="btn-secondary" onclick="editSelectedEvent()">
                            <i class="fas fa-edit"></i>
                            Edit
                        </button>
                        <button class="btn-primary" onclick="viewSelectedEvent()">
                            <i class="fas fa-share"></i>
                            View Public
                        </button>
                    </div>
                </div>

                <div class="event-details-content">
                    <div class="event-details-placeholder">
                        <i class="fas fa-mouse-pointer"></i>
                        <h5>Select an event</h5>
                        <p>Click on an event from the list to view its details</p>
                    </div>

                    <div class="event-details-active" style="display: none;">
                        <div class="event-hero-details">
                            <div class="event-hero-image">
                                <div class="event-image-placeholder">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                <div class="event-hero-overlay">
                                    <span class="event-category" id="detailEventCategory">Cultural</span>
                                    <span class="event-type" id="detailEventType">Free</span>
                                </div>
                            </div>
                            <div class="event-hero-info">
                                <h3 id="detailEventTitle">Event Title</h3>
                                <p id="detailEventDescription">Description of the selected event...</p>
                            </div>
                        </div>

                        <div class="event-details-grid">
                            <div class="detail-section">
                                <h6><i class="fas fa-info-circle"></i> General Information</h6>
                                <div class="detail-items">
                                    <div class="detail-item">
                                        <span class="detail-label">Date & Time:</span>
                                        <span class="detail-value" id="detailEventDateTime"></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Location:</span>
                                        <span class="detail-value" id="detailEventLocation"></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Status:</span>
                                        <span class="detail-value" id="detailEventStatus">Scheduled</span>
                                    </div>
                                </div>
                            </div>

                            <div class="detail-section">
                                <h6><i class="fas fa-chart-bar"></i> Statistics</h6>
                                <div class="detail-stats">
                                    <div class="detail-stat">
                                        <div class="stat-value" id="detailEventAttendees">0</div>
                                        <div class="stat-label">Confirmed</div>
                                    </div>
                                    <div class="detail-stat">
                                        <div class="stat-value" id="detailEventCapacity">0</div>
                                        <div class="stat-label">Capacity</div>
                                    </div>
                                    <div class="detail-stat">
                                        <div class="stat-value" id="detailEventOccupancy">0%</div>
                                        <div class="stat-label">Occupancy</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendees and Participation -->
    <div class="manager-attendance-section" data-aos="fade-up">
        <div class="attendance-header">
            <h3><i class="fas fa-user-check"></i> Attendee Management</h3>
            <div class="attendance-summary">
                <div class="summary-item">
                    <strong>{{ $total_attendees ?? 0 }}</strong>
                    <span>Total Attendees</span>
                </div>
                <div class="summary-item">
                    <strong>{{ $confirmed_attendees ?? 0 }}</strong>
                    <span>Confirmed</span>
                </div>
                <div class="summary-item">
                    <strong>{{ $average_attendance ?? 0 }}%</strong>
                    <span>Average Attendance</span>
                </div>
            </div>
        </div>

        <div class="attendance-details">
            @if($event_attendees && $event_attendees->count() > 0)
            <div class="attendees-list">
                <h5>Recent Attendees</h5>
                <div class="attendees-scrollable">
                    @foreach($event_attendees->take(6) as $attendance)
                    <div class="attendee-item">
                        <div class="attendee-avatar">
                            @if($attendance->user->profile_picture)
                                <img src="{{ Storage::url($attendance->user->profile_picture) }}" alt="{{ $attendance->user->name }}">
                            @else
                                <div class="avatar-initials-small">
                                    {{ strtoupper(substr($attendance->user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="attendee-info">
                            <div class="attendee-name">{{ $attendance->user->name }}</div>
                            <div class="attendee-event">{{ $attendance->event->post->title ?? 'Event' }}</div>
                        </div>
                        <div class="attendee-meta">
                            <span class="attendee-date">{{ $attendance->created_at->diffForHumans() }}</span>
                            <span class="attendee-status {{ $attendance->status }}">{{ $attendance->status }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="empty-attendance">
                <i class="fas fa-users-slash"></i>
                <h5>No registered attendees</h5>
                <p>Attendees will appear here when they register for your events</p>
            </div>
            @endif

            <div class="attendance-actions">
                <button class="attendance-action-btn" onclick="showNotification('Function under development')">
                    <i class="fas fa-download"></i>
                    Export List
                </button>
                <button class="attendance-action-btn" onclick="showNotification('Function under development')">
                    <i class="fas fa-bullhorn"></i>
                    Notify Attendees
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions-section">
        <h2>Quick Actions</h2>
        <div class="actions-grid">
            <a href="{{ route('events.create') }}" class="action-card">
                <div class="action-icon primary">
                    <i class="fas fa-calendar-plus"></i>
                </div>
                <h4>Create Event</h4>
                <p>Organize a new cultural event</p>
            </a>
            
            <a href="{{ route('events.index') }}" class="action-card">
                <div class="action-icon success">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h4>My Events</h4>
                <p>Manage all your events</p>
            </a>
            
            <a href="{{ route('locations.index') }}" class="action-card">
                <div class="action-icon info">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h4>Venues</h4>
                <p>Manage locations</p>
            </a>
            
            <a href="#" class="action-card" onclick="showNotification('Reports under development')">
                <div class="action-icon warning">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h4>Reports</h4>
                <p>View detailed statistics</p>
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// JavaScript for cultural manager dashboard
document.addEventListener('DOMContentLoaded', function() {
    initEventsManagement();
    initEventFilters();
    
    // Counter animations
    animateManagerCounters();
});

function initEventsManagement() {
    const eventItems = document.querySelectorAll('.event-list-item');
    const detailsActive = document.querySelector('.event-details-active');
    const detailsPlaceholder = document.querySelector('.event-details-placeholder');

    eventItems.forEach(item => {
        item.addEventListener('click', function() {
            const eventId = this.getAttribute('data-event-id');
            
            // Remove previous selection
            eventItems.forEach(i => i.classList.remove('selected'));
            // Add current selection
            this.classList.add('selected');
            
            // Show details
            if (detailsActive && detailsPlaceholder) {
                detailsPlaceholder.style.display = 'none';
                detailsActive.style.display = 'block';
                
                // Load event data
                loadEventDetails(eventId);
            }
        });
    });
}

function initEventFilters() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            // Remove active from all
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Apply filter
            filterEvents(filter);
        });
    });
}

function filterEvents(filter) {
    const eventItems = document.querySelectorAll('.event-list-item');
    
    eventItems.forEach(item => {
        const eventStatus = item.getAttribute('data-status');
        
        switch(filter) {
            case 'all':
                item.style.display = 'flex';
                break;
            case 'upcoming':
                item.style.display = eventStatus === 'upcoming' ? 'flex' : 'none';
                break;
            case 'past':
                item.style.display = eventStatus === 'past' ? 'flex' : 'none';
                break;
        }
    });
}

function loadEventDetails(eventId) {
    // Simulate loading event details
    console.log(`Loading event details: ${eventId}`);
    
    // AJAX call to get event details would go here
    const eventData = {
        title: 'Test Cultural Event',
        description: 'Detailed description of the selected cultural event...',
        dateTime: '15 Dec 2024, 6:00 PM',
        location: 'Municipal Theater of Popayán',
        attendees: 45,
        capacity: 100,
        type: 'Free',
        category: 'Cultural'
    };
    
    // Update UI with event data
    document.getElementById('detailEventTitle').textContent = eventData.title;
    document.getElementById('detailEventDescription').textContent = eventData.description;
    document.getElementById('detailEventDateTime').textContent = eventData.dateTime;
    document.getElementById('detailEventLocation').textContent = eventData.location;
    document.getElementById('detailEventAttendees').textContent = eventData.attendees;
    document.getElementById('detailEventCapacity').textContent = eventData.capacity;
    document.getElementById('detailEventOccupancy').textContent = Math.round((eventData.attendees / eventData.capacity) * 100) + '%';
    document.getElementById('detailEventType').textContent = eventData.type;
    document.getElementById('detailEventCategory').textContent = eventData.category;
    
    showNotification('Event details loaded successfully', 'success');
}

function editSelectedEvent() {
    const selectedEvent = document.querySelector('.event-list-item.selected');
    if (selectedEvent) {
        const eventId = selectedEvent.getAttribute('data-event-id');
        window.location.href = `/events/${eventId}/edit`;
    } else {
        showNotification('Select an event first', 'warning');
    }
}

function viewSelectedEvent() {
    const selectedEvent = document.querySelector('.event-list-item.selected');
    if (selectedEvent) {
        const eventId = selectedEvent.getAttribute('data-event-id');
        window.open(`/events/${eventId}`, '_blank');
    } else {
        showNotification('Select an event first', 'warning');
    }
}

function animateManagerCounters() {
    const counters = document.querySelectorAll('.stat-number, .overview-value');
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
}

function showNotification(message, type = 'info') {
    // Create simple notification
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${type === 'success' ? 'check' : type === 'warning' ? 'exclamation' : 'info'}-circle"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Entry animation
    setTimeout(() => notification.classList.add('show'), 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Styles for notifications
const style = document.createElement('style');
style.textContent = `
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: white;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border-left: 4px solid #3498db;
        transform: translateX(400px);
        transition: transform 0.3s ease;
        z-index: 1000;
        max-width: 300px;
    }
    
    .notification.success { border-left-color: #27ae60; }
    .notification.warning { border-left-color: #f39c12; }
    .notification.info { border-left-color: #3498db; }
    
    .notification.show { transform: translateX(0); }
    
    .notification-content {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .notification-content i {
        font-size: 1.2em;
    }
    
    .notification.success i { color: #27ae60; }
    .notification.warning i { color: #f39c12; }
    .notification.info i { color: #3498db; }
`;
document.head.appendChild(style);
</script>
@endsection