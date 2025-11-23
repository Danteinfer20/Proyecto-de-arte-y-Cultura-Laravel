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
            <li><a href="{{ url('/') }}">Inicio</a></li>
            <li><a href="{{ url('/events') }}">Eventos</a></li>
            <li><a href="{{ url('/products') }}">Productos</a></li>
            <li><a href="{{ url('/posts') }}">Blog</a></li>
        </ul>

        <!-- Auth Links -->
        <ul class="auth-links">
            <li><a href="{{ url('/login') }}">Iniciar Sesión</a></li>
            <li><a href="{{ url('/register') }}" class="register-btn">Registrarse</a></li>
        </ul>
    </nav>
</header>