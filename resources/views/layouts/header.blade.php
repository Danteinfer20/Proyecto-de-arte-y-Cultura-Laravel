<header class="header">
    <nav class="navbar">
        <!-- Logo -->
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Arte y Cultura Popayán" class="logo-img">
        </div>

        <!-- Menú Hamburguesa (Mobile) -->
        <button class="menu-toggle" aria-label="Abrir menú">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <!-- Navegación Desktop -->
        <ul class="nav-links">
            <li><a href="{{ route('home') }}">Inicio</a></li>
            <li><a href="{{ route('events.index') }}">Eventos</a></li>
            <li><a href="{{ route('products.index') }}">Productos</a></li>
            <li><a href="{{ route('posts.index') }}">Blog</a></li>
            <li><a href="{{ route('about') }}">Nosotros</a></li>
        </ul>

        <!-- Auth Links - CONDICIONAL -->
        @auth
            <!-- Usuario logueado -->
            <div class="user-menu">
                <button class="user-toggle" aria-label="Menú de usuario">
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
                        @include('icons.user')
                        Mi Perfil
                    </a>
                    <a href="{{ route('dashboard') }}" class="dropdown-item">
                        @include('icons.dashboard')
                        Dashboard
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}" class="dropdown-form">
                        @csrf
                        <button type="submit" class="dropdown-item logout-btn">
                            @include('icons.logout')
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        @else
            <!-- Usuario NO logueado -->
            <ul class="auth-links">
                <li><a href="{{ route('login') }}">Iniciar Sesión</a></li>
                <li><a href="{{ route('register') }}" class="register-btn">Registrarse</a></li>
            </ul>
        @endauth
    </nav>
</header>