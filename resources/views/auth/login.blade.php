@extends('layouts.app', ['hideHeader' => true, 'hideFooter' => true])

@section('title', 'Iniciar Sesión - Cultura Popayán')

@section('content')
<div class="auth-container">
    <div class="auth-background">
        <div class="auth-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>
    </div>
    
    <div class="auth-wrapper">
        <div class="auth-card">
            <!-- Header -->
            <div class="auth-header">
                <a href="{{ route('home') }}" class="auth-logo">
                    @include('icons.heritage')
                    <span>ArtePayán</span>
                </a>
                <h1>Bienvenido de vuelta</h1>
                <p>Ingresa a tu cuenta para continuar</p>
            </div>

            <!-- Formulario -->
            <form method="POST" action="{{ route('login') }}" class="auth-form">
                @csrf

                <!-- Alertas -->
                @if($errors->any())
                    <div class="alert alert-error">
                        @include('icons.close')
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        @include('icons.check')
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Campos -->
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <div class="input-wrapper">
                        @include('icons.email')
                        <input type="email" id="email" name="email" value="{{ old('email') }}" 
                               required autofocus placeholder="tu@email.com">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="input-wrapper">
                        @include('icons.lock')
                        <input type="password" id="password" name="password" 
                               required placeholder="••••••••">
                        <button type="button" class="password-toggle">
                            @include('icons.eye')
                        </button>
                    </div>
                </div>

                <div class="form-options">
                    <label class="checkbox">
                        <input type="checkbox" name="remember">
                        <span class="checkmark"></span>
                        Recordar sesión
                    </label>
                    <a href="#" class="forgot-link">¿Olvidaste tu contraseña?</a>
                </div>

                <button type="submit" class="btn btn-primary btn-full">
                    @include('icons.login')
                    Iniciar Sesión
                </button>
            </form>

            <!-- Separador -->
            <div class="auth-divider">
                <span>o continúa con</span>
            </div>

            <!-- Login Social -->
            <div class="social-auth">
                <button type="button" class="btn btn-social btn-google">
                    @include('icons.google')
                    Google
                </button>
                <button type="button" class="btn btn-social btn-facebook">
                    @include('icons.facebook')
                    Facebook
                </button>
            </div>

            <!-- Footer -->
            <div class="auth-footer">
                <p>¿No tienes una cuenta? 
                    <a href="{{ route('register') }}">Regístrate aquí</a>
                </p>
            </div>
        </div>

        <!-- Lado decorativo -->
        <div class="auth-decoration">
            <div class="decoration-content">
                <h2>Descubre la magia de Popayán</h2>
                <p>Accede a eventos exclusivos, artesanías únicas y toda la riqueza cultural de la Ciudad Blanca.</p>
                <div class="decoration-features">
                    <div class="feature">
                        @include('icons.events')
                        <span>Eventos Culturales</span>
                    </div>
                    <div class="feature">
                        @include('icons.products')
                        <span>Artesanías Únicas</span>
                    </div>
                    <div class="feature">
                        @include('icons.heart')
                        <span>Contenido Exclusivo</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Estilos específicos para auth */
.auth-container {
    min-height: 100vh;
    background: linear-gradient(135deg, var(--azul-profundo) 0%, var(--azul-suave) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    position: relative;
    overflow: hidden;
}

.auth-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0.1;
}

.auth-shapes .shape {
    position: absolute;
    border-radius: 50%;
    background: var(--luna-dorada);
}

.shape-1 {
    width: 300px;
    height: 300px;
    top: -150px;
    right: -100px;
    opacity: 0.3;
}

.shape-2 {
    width: 200px;
    height: 200px;
    bottom: -50px;
    left: -50px;
    opacity: 0.2;
}

.shape-3 {
    width: 150px;
    height: 150px;
    top: 50%;
    right: 20%;
    opacity: 0.15;
}

.auth-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    max-width: 1000px;
    width: 100%;
    background: var(--blanco-puro);
    border-radius: var(--borde-redondeado-lg);
    box-shadow: var(--sombra-fuerte);
    overflow: hidden;
    min-height: 600px;
}

.auth-card {
    padding: 3rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.auth-header {
    text-align: center;
    margin-bottom: 2rem;
}

.auth-logo {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--azul-profundo);
    text-decoration: none;
    margin-bottom: 1rem;
}

.auth-logo .icon {
    width: 32px;
    height: 32px;
    color: var(--luna-dorada);
}

.auth-header h1 {
    font-size: 2rem;
    color: var(--azul-profundo);
    margin-bottom: 0.5rem;
}

.auth-header p {
    color: var(--gris-azulado);
}

.auth-form {
    margin-bottom: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--azul-profundo);
}

.input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.input-wrapper .icon {
    position: absolute;
    left: 1rem;
    width: 20px;
    height: 20px;
    color: var(--gris-azulado);
    z-index: 2;
}

.input-wrapper input {
    width: 100%;
    padding: 1rem 1rem 1rem 3rem;
    border: 2px solid var(--gris-plata);
    border-radius: var(--borde-redondeado-sm);
    font-size: 1rem;
    transition: var(--transicion);
    background: var(--blanco-puro);
}

.input-wrapper input:focus {
    outline: none;
    border-color: var(--azul-electrico);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.password-toggle {
    position: absolute;
    right: 1rem;
    background: none;
    border: none;
    cursor: pointer;
    color: var(--gris-azulado);
    padding: 0.5rem;
}

.password-toggle .icon {
    position: static;
    width: 18px;
    height: 18px;
}

.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.checkbox {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    font-size: 0.9rem;
    color: var(--gris-azulado);
}

.checkbox input {
    display: none;
}

.checkmark {
    width: 18px;
    height: 18px;
    border: 2px solid var(--gris-plata);
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transicion);
}

.checkbox input:checked + .checkmark {
    background: var(--azul-electrico);
    border-color: var(--azul-electrico);
}

.checkbox input:checked + .checkmark::after {
    content: '✓';
    color: white;
    font-size: 12px;
    font-weight: bold;
}

.forgot-link {
    color: var(--azul-electrico);
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
}

.forgot-link:hover {
    text-decoration: underline;
}

.btn-full {
    width: 100%;
    justify-content: center;
    margin-bottom: 1.5rem;
}

.auth-divider {
    display: flex;
    align-items: center;
    margin: 2rem 0;
    color: var(--gris-azulado);
}

.auth-divider::before,
.auth-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--gris-plata);
}

.auth-divider span {
    padding: 0 1rem;
    font-size: 0.9rem;
}

.social-auth {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 2rem;
}

.btn-social {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    border: 2px solid var(--gris-plata);
    background: var(--blanco-puro);
    color: var(--azul-profundo);
    border-radius: var(--borde-redondeado-sm);
    font-weight: 500;
    transition: var(--transicion);
}

.btn-social:hover {
    border-color: var(--azul-electrico);
    transform: translateY(-2px);
}

.btn-google:hover {
    border-color: #DB4437;
}

.btn-facebook:hover {
    border-color: #4267B2;
}

.btn-social .icon {
    width: 18px;
    height: 18px;
}

.auth-footer {
    text-align: center;
    padding-top: 1.5rem;
    border-top: 1px solid var(--gris-plata);
}

.auth-footer a {
    color: var(--azul-electrico);
    font-weight: 600;
    text-decoration: none;
}

.auth-footer a:hover {
    text-decoration: underline;
}

.auth-decoration {
    background: linear-gradient(135deg, var(--azul-electrico) 0%, var(--azul-celeste) 100%);
    color: var(--blanco-puro);
    padding: 3rem;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.decoration-content {
    position: relative;
    z-index: 2;
    text-align: center;
}

.decoration-content h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
    font-weight: 700;
}

.decoration-content p {
    font-size: 1.1rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.decoration-features {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.feature {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: var(--borde-redondeado-sm);
    backdrop-filter: blur(10px);
}

.feature .icon {
    width: 24px;
    height: 24px;
    color: var(--luna-dorada);
}

/* Alertas */
.alert {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem;
    border-radius: var(--borde-redondeado-sm);
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
}

.alert-error {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.2);
    color: #DC2626;
}

.alert-success {
    background: rgba(16, 185, 129, 0.1);
    border: 1px solid rgba(16, 185, 129, 0.2);
    color: #059669;
}

.alert .icon {
    width: 16px;
    height: 16px;
}

/* Responsive */
@media (max-width: 768px) {
    .auth-wrapper {
        grid-template-columns: 1fr;
    }
    
    .auth-decoration {
        display: none;
    }
    
    .auth-card {
        padding: 2rem;
    }
    
    .social-auth {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .auth-container {
        padding: 1rem;
    }
    
    .auth-card {
        padding: 1.5rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Toggle password visibility
document.querySelectorAll('.password-toggle').forEach(button => {
    button.addEventListener('click', function() {
        const input = this.closest('.input-wrapper').querySelector('input');
        const icon = this.querySelector('.icon');
        
        if (input.type === 'password') {
            input.type = 'text';
            // Cambiar icono a ojo cerrado (necesitarías crear este icono)
        } else {
            input.type = 'password';
            // Cambiar icono a ojo abierto
        }
    });
});
</script>
@endpush