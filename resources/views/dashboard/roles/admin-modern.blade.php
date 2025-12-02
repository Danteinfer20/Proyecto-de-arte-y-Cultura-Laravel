@extends('layouts.dashboard')
@section('title', 'Admin Dashboard')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link href="{{ asset('css/pages/dashboard-admin.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="admin-dashboard">
    <!-- Admin Header -->
    <header class="admin-header">
        <div class="header-content">
            <div class="admin-welcome">
                <h1>Administration Panel</h1>
                <p>Complete management of the cultural platform</p>
            </div>
            <div class="admin-actions">
                <div class="quick-stats">
                    <div class="quick-stat">
                        <i class="fas fa-users"></i>
                        <span>Total users: {{ $total_users ?? 0 }}</span>
                    </div>
                    <div class="quick-stat">
                        <i class="fas fa-shield-alt"></i>
                        <span>Role: Administrator</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Metrics -->
    <section class="metrics-grid">
        <!-- Users Card -->
        <div class="metric-card users-card">
            <div class="metric-header">
                <h3><i class="fas fa-users"></i> Users</h3>
                <div class="metric-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    15%
                </div>
            </div>
            <div class="metric-value">{{ $total_users ?? 0 }}</div>
            <div class="metric-breakdown">
                <div class="breakdown-item">
                    <span class="label">Artists</span>
                    <span class="value">{{ $artist_count ?? 0 }}</span>
                </div>
                <div class="breakdown-item">
                    <span class="label">Managers</span>
                    <span class="value">{{ $manager_count ?? 0 }}</span>
                </div>
                <div class="breakdown-item">
                    <span class="label">Visitors</span>
                    <span class="value">{{ $visitor_count ?? 0 }}</span>
                </div>
            </div>
        </div>

        <!-- Content Card -->
        <div class="metric-card content-card">
            <div class="metric-header">
                <h3><i class="fas fa-palette"></i> Content</h3>
                <div class="metric-badge">
                    {{ $total_posts ?? 0 }} posts
                </div>
            </div>
            <div class="metric-value">{{ $total_posts ?? 0 }}</div>
            <div class="content-stats">
                <div class="content-stat">
                    <i class="fas fa-calendar"></i>
                    <span>Events: {{ $event_count ?? 0 }}</span>
                </div>
                <div class="content-stat">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Products: {{ $product_count ?? 0 }}</span>
                </div>
                <div class="content-stat">
                    <i class="fas fa-newspaper"></i>
                    <span>Posts: {{ $post_count ?? 0 }}</span>
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="metric-card revenue-card">
            <div class="metric-header">
                <h3><i class="fas fa-chart-line"></i> Revenue</h3>
                <div class="metric-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    8%
                </div>
            </div>
            <div class="metric-value">${{ number_format($total_revenue ?? 0, 0) }}</div>
            <div class="revenue-chart">
                <!-- Mini chart placeholder -->
                <div class="chart-bars">
                    <div class="chart-bar" style="height: 40%"></div>
                    <div class="chart-bar" style="height: 60%"></div>
                    <div class="chart-bar" style="height: 80%"></div>
                    <div class="chart-bar" style="height: 70%"></div>
                    <div class="chart-bar" style="height: 90%"></div>
                </div>
            </div>
        </div>

        <!-- Moderation Card -->
        <div class="metric-card moderation-card">
            <div class="metric-header">
                <h3><i class="fas fa-shield-alt"></i> Moderation</h3>
                <div class="metric-badge alert">
                    {{ $pending_approvals ?? 0 }} pending
                </div>
            </div>
            <div class="moderation-stats">
                <div class="moderation-item">
                    <i class="fas fa-flag"></i>
                    <span>Reports: {{ $pending_reports ?? 0 }}</span>
                </div>
                <div class="moderation-item">
                    <i class="fas fa-clock"></i>
                    <span>To approve: {{ $pending_approvals ?? 0 }}</span>
                </div>
                <div class="moderation-item">
                    <i class="fas fa-comment"></i>
                    <span>Comments: {{ $recent_comments ?? 0 }}</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="main-content">
        <!-- Recent Users -->
        <div class="content-section">
            <div class="section-header">
                <h2>Recent Users</h2>
                @if(Route::has('admin.users'))
                    <a href="{{ route('admin.users') }}" class="btn-primary">
                        <i class="fas fa-list"></i>
                        View All
                    </a>
                @else
                    <a href="#" class="btn-primary" onclick="alert('Feature under development')">
                        <i class="fas fa-list"></i>
                        View All
                    </a>
                @endif
            </div>
            <div class="users-table">
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Role</th>
                            <th>Registration</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_users ?? [] as $user)
                        <tr>
                            <td>
                                <div class="user-info">
                                    @if($user->profile_picture)
                                        <img src="{{ Storage::url($user->profile_picture) }}" alt="{{ $user->name }}" class="user-avatar-img">
                                    @else
                                        <div class="user-avatar">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div class="user-details">
                                        <strong>{{ $user->name }}</strong>
                                        <br>
                                        <small>{{ $user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="role-badge {{ $user->user_type }}">
                                    @switch($user->user_type)
                                        @case('artist')
                                            <i class="fas fa-palette"></i> Artist
                                            @break
                                        @case('cultural_manager')
                                            <i class="fas fa-calendar"></i> Manager
                                            @break
                                        @case('admin')
                                            <i class="fas fa-crown"></i> Admin
                                            @break
                                        @case('educator')
                                            <i class="fas fa-graduation-cap"></i> Educator
                                            @break
                                        @default
                                            <i class="fas fa-user"></i> Visitor
                                    @endswitch
                                </span>
                            </td>
                            <td class="registration-date">{{ $user->created_at->diffForHumans() }}</td>
                            <td>
                                <span class="status-badge {{ $user->status ?? 'active' }}">
                                    @switch($user->status ?? 'active')
                                        @case('active')
                                            <i class="fas fa-check-circle"></i> Active
                                            @break
                                        @case('suspended')
                                            <i class="fas fa-pause-circle"></i> Suspended
                                            @break
                                        @case('inactive')
                                            <i class="fas fa-minus-circle"></i> Inactive
                                            @break
                                        @default
                                            <i class="fas fa-check-circle"></i> Active
                                    @endswitch
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-action" title="Edit user" onclick="editUser({{ $user->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action" title="View profile" onclick="viewProfile({{ $user->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action btn-danger" title="Delete user" onclick="deleteUser({{ $user->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="empty-state">
                                <i class="fas fa-users"></i>
                                <p>No registered users</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Posts -->
        <div class="content-section">
            <div class="section-header">
                <h2>Recent Content</h2>
                <a href="{{ route('posts.index') }}" class="btn-primary">
                    <i class="fas fa-newspaper"></i>
                    View All
                </a>
            </div>
            <div class="posts-grid">
                @forelse($recent_posts ?? [] as $post)
                <div class="post-card">
                    <div class="post-header">
                        <div class="post-author">
                            @if($post->user->profile_picture)
                                <img src="{{ Storage::url($post->user->profile_picture) }}" alt="{{ $post->user->name }}" class="author-avatar">
                            @else
                                <div class="author-avatar-placeholder">
                                    {{ substr($post->user->name, 0, 1) }}
                                </div>
                            @endif
                            <span class="author-name">{{ $post->user->name }}</span>
                        </div>
                        <span class="post-date">{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="post-content">
                        <h4 class="post-title">{{ Str::limit($post->title, 50) }}</h4>
                        <p class="post-excerpt">{{ Str::limit($post->content, 100) }}</p>
                    </div>
                    <div class="post-footer">
                        <div class="post-stats">
                            <span><i class="fas fa-eye"></i> {{ $post->view_count ?? 0 }}</span>
                            <span><i class="fas fa-heart"></i> {{ $post->reactions_count ?? 0 }}</span>
                            <span><i class="fas fa-comment"></i> {{ $post->comments_count ?? 0 }}</span>
                        </div>
                        <div class="post-actions">
                            <a href="{{ route('posts.show', $post) }}" class="btn-action" title="View post">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                            <button class="btn-action" title="Edit post" onclick="editPost({{ $post->id }})">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <i class="fas fa-newspaper"></i>
                    <p>No published content</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions-section">
            <h2>Quick Actions</h2>
            <div class="actions-grid">
                @if(Route::has('admin.users'))
                <a href="{{ route('admin.users') }}" class="action-card">
                    <div class="action-icon primary">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <h4>Manage Users</h4>
                    <p>Manage all users</p>
                </a>
                @else
                <a href="#" class="action-card" onclick="alert('User management under development')">
                    <div class="action-icon primary">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <h4>Manage Users</h4>
                    <p>Manage all users</p>
                </a>
                @endif
                
                @if(Route::has('admin.moderate'))
                <a href="{{ route('admin.moderate') }}" class="action-card">
                    <div class="action-icon warning">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4>Moderate Content</h4>
                    <p>Review reports and approvals</p>
                </a>
                @else
                <a href="#" class="action-card" onclick="alert('Moderation under development')">
                    <div class="action-icon warning">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4>Moderate Content</h4>
                    <p>Review reports and approvals</p>
                </a>
                @endif
                
                @if(Route::has('admin.analytics'))
                <a href="{{ route('admin.analytics') }}" class="action-card">
                    <div class="action-icon info">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h4>View Analytics</h4>
                    <p>Platform statistics</p>
                </a>
                @else
                <a href="#" class="action-card" onclick="alert('Analytics under development')">
                    <div class="action-icon info">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h4>View Analytics</h4>
                    <p>Platform statistics</p>
                </a>
                @endif
                
                @if(Route::has('admin.settings'))
                <a href="{{ route('admin.settings') }}" class="action-card">
                    <div class="action-icon success">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h4>Settings</h4>
                    <p>Platform settings</p>
                </a>
                @else
                <a href="#" class="action-card" onclick="alert('Settings under development')">
                    <div class="action-icon success">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h4>Settings</h4>
                    <p>Platform settings</p>
                </a>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
// JavaScript for admin dashboard
document.addEventListener('DOMContentLoaded', function() {
    // Basic animations
    const metricCards = document.querySelectorAll('.metric-card');
    metricCards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Placeholder charts
    const chartBars = document.querySelectorAll('.chart-bar');
    chartBars.forEach((bar, index) => {
        setTimeout(() => {
            bar.style.opacity = '1';
        }, index * 150);
    });

    // Hover effects on cards
    const actionCards = document.querySelectorAll('.action-card');
    actionCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});

// Admin functions
function editUser(userId) {
    alert('Edit user: ' + userId + ' - Function under development');
    // Logic for editing user would go here
}

function viewProfile(userId) {
    window.open('/users/' + userId, '_blank');
}

function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
        alert('Delete user: ' + userId + ' - Function under development');
        // AJAX call to delete user would go here
    }
}

function editPost(postId) {
    window.open('/posts/' + postId + '/edit', '_blank');
}
</script>
@endsection