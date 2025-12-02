<header class="header">
    <nav class="navbar">
        <!-- Logo -->
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Art and Culture Popayán" class="logo-img">
        </div>

        <!-- Hamburger Menu (Mobile) -->
        <button class="menu-toggle" aria-label="Open menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <!-- Desktop Navigation -->
        <ul class="nav-links">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('events.index') }}">Events</a></li>
            <li><a href="{{ route('products.index') }}">Products</a></li>
            <li><a href="{{ route('about') }}">About Us</a></li>
        </ul>

        <!-- Auth Links - CONDITIONAL -->
        @auth
            <!-- Logged in user -->
            <div class="user-menu">
                <button class="user-toggle" aria-label="User menu">
                    <span class="user-avatar">
                        @if(Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="{{ Auth::user()->name }}">
                        @else
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        @endif
                    </span>
                    <span class="user-name">{{ Auth::user()->name }}</span>
                </button>
                <div class="user-dropdown">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        @include('components.user')
                        My Profile
                    </a>
                    <a href="{{ route('dashboard') }}" class="dropdown-item">
                        @include('components.dashboard')
                        Dashboard
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}" class="dropdown-form">
                        @csrf
                        <button type="submit" class="dropdown-item logout-btn">
                            @include('components.logout')
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        @else
            <!-- NOT logged in user -->
            <ul class="auth-links">
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}" class="register-btn">Register</a></li>
            </ul>
        @endauth
    </nav>
</header>