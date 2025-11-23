<footer class="footer">
    <div class="footer-content">
        <!-- Logo y Descripción -->
        <div class="footer-brand">
            <div class="footer-logo">
                <img src="{{ asset('images/logo.png') }}" alt="Arte y Cultura Popayán" class="footer-logo-img">
              
            </div>
            <p class="footer-description">
                Promovemos y preservamos el patrimonio cultural, artístico y tradicional de la hermosa ciudad de Popayán, Cauca.
            </p>
        </div>

        <!-- Enlaces Importantes -->
        <div class="footer-links">
            <h3>Enlaces Rápidos</h3>
            <ul>
                <li><a href="{{ url('/') }}">@include('icons.home') Inicio</a></li>
                <li><a href="{{ url('/events') }}">@include('icons.events') Eventos</a></li>
                <li><a href="{{ url('/products') }}">@include('icons.products') Productos</a></li>
                <li><a href="{{ url('/posts') }}">@include('icons.blog') Blog</a></li>
                <li><a href="{{ url('/about') }}">@include('icons.about') Nosotros</a></li>
            </ul>
        </div>

        <!-- Redes Sociales -->
        <div class="footer-social">
            <h3>Síguenos</h3>
            <div class="social-links">
                <a href="#" class="social-link" aria-label="Facebook">
                    @include('icons.social-facebook')
                </a>
                <a href="#" class="social-link" aria-label="Instagram">
                    @include('icons.social-instagram')
                </a>
                <a href="#" class="social-link" aria-label="YouTube">
                    @include('icons.social-youtube')
                </a>
                <a href="#" class="social-link" aria-label="TikTok">
                    @include('icons.social-tiktok')
                </a>
            </div>
        </div>

        <!-- Información de Contacto -->
        <div class="footer-contact">
            <h3>Contacto</h3>
            <div class="contact-info">
                <div class="contact-item">
                    @include('icons.email')
                    <span>info@arteycultura.com</span>
                </div>
                <div class="contact-item">
                    @include('icons.phone')
                    <span>+57 602 823 4567</span>
                </div>
                <div class="contact-item">
                    @include('icons.location')
                    <span>Popayán, Cauca - Colombia</span>
                </div>
                <div class="contact-item">
                    @include('icons.clock')
                    <span>Lun-Vie: 8:00 AM - 6:00 PM</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Derechos de Autor -->
    <div class="footer-bottom">
        <p>&copy; 2024 Arte & Cultura Popayán. Todos los derechos reservados.</p>
    </div>
</footer>