<footer class="footer">
    <div class="footer-content">
        <!-- Logo and Description -->
        <div class="footer-brand">
            <div class="footer-logo">
                <img src="{{ asset('images/logo.png') }}" alt="Art and Culture Popayán" class="footer-logo-img">
            </div>
            <p class="footer-description">
                We promote and preserve the cultural, artistic, and traditional heritage of the beautiful city of Popayán, Cauca.
            </p>
        </div>

        <!-- Important Links -->
        <div class="footer-links">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="{{ url('/') }}">@include('components.home') Home</a></li>
                <li><a href="{{ url('/events') }}">@include('components.events') Events</a></li>
                <li><a href="{{ url('/products') }}">@include('components.products') Products</a></li>
                <li><a href="{{ url('/posts') }}">@include('components.blog') Blog</a></li>
                <li><a href="{{ url('/about') }}">@include('components.about') About Us</a></li>
            </ul>
        </div>

        <!-- Social Media -->
        <div class="footer-social">
            <h3>Follow Us</h3>
            <div class="social-links">
                <a href="#" class="social-link" aria-label="Facebook">
                    @include('components.social-facebook')
                </a>
                <a href="#" class="social-link" aria-label="Instagram">
                    @include('components.social-instagram')
                </a>
                <a href="#" class="social-link" aria-label="YouTube">
                    @include('components.social-youtube')
                </a>
                <a href="#" class="social-link" aria-label="TikTok">
                    @include('components.social-tiktok')
                </a>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="footer-contact">
            <h3>Contact</h3>
            <div class="contact-info">
                <div class="contact-item">
                    @include('components.email')
                    <span>info@arteycultura.com</span>
                </div>
                <div class="contact-item">
                    @include('components.phone')
                    <span>+57 602 823 4567</span>
                </div>
                <div class="contact-item">
                    @include('components.location')
                    <span>Popayán, Cauca - Colombia</span>
                </div>
                <div class="contact-item">
                    @include('components.clock')
                    <span>Mon-Fri: 8:00 AM - 6:00 PM</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="footer-bottom">
        <p>&copy; 2024 Art & Culture Popayán. All rights reserved.</p>
    </div>
</footer>