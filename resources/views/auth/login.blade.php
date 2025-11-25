@extends('layouts.app')

@section('title', 'Iniciar Sesión - Arte & Cultura Popayán')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <!-- Header Elegante -->
        <div class="auth-header">
            <div class="auth-icon">
                <i class="fas fa-sign-in-alt"></i>
            </div>
            <h1>Bienvenido de Nuevo</h1>
            <p>Accede a tu cuenta para explorar la cultura de Popayán</p>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="auth-form" id="loginForm">
            @csrf
            
            <div class="form-group floating-label">
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                <label for="email">Correo Electrónico</label>
                <div class="form-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group floating-label">
                <input type="password" id="password" name="password" required>
                <label for="password">Contraseña</label>
                <div class="form-icon">
                    <i class="fas fa-lock"></i>
                </div>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-options">
                <div class="checkbox-group">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">
                        <span class="checkbox-check"></span>
                        Recordar sesión
                    </label>
                </div>
                
                <div class="forgot-password">
                    <a href="{{ url('/forgot-password') }}">¿Olvidaste tu contraseña?</a>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-full" id="loginBtn">
                <span class="btn-text">Iniciar Sesión</span>
                <div class="btn-loading" style="display: none;">
                    <i class="fas fa-spinner fa-spin"></i> Iniciando sesión...
                </div>
            </button>
        </form>

        <div class="auth-footer">
            <p>¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// JavaScript para el login
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const loginBtn = document.getElementById('loginBtn');
    const btnText = loginBtn.querySelector('.btn-text');
    const btnLoading = loginBtn.querySelector('.btn-loading');

    // Validación en tiempo real
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');

    emailInput.addEventListener('blur', validateEmail);
    passwordInput.addEventListener('blur', validatePassword);

    function validateEmail() {
        const email = emailInput.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (!emailRegex.test(email)) {
            showFieldError(emailInput, 'Por favor ingresa un correo electrónico válido');
            return false;
        } else {
            clearFieldError(emailInput);
            return true;
        }
    }

    function validatePassword() {
        const password = passwordInput.value.trim();
        
        if (password.length === 0) {
            showFieldError(passwordInput, 'La contraseña es obligatoria');
            return false;
        } else {
            clearFieldError(passwordInput);
            return true;
        }
    }

    function showFieldError(field, message) {
        let errorElement = field.parentNode.querySelector('.error-message');
        
        if (!errorElement) {
            errorElement = document.createElement('span');
            errorElement.className = 'error-message';
            field.parentNode.appendChild(errorElement);
        }
        
        errorElement.textContent = message;
        field.style.borderColor = '#EF4444';
    }

    function clearFieldError(field) {
        const errorElement = field.parentNode.querySelector('.error-message');
        if (errorElement) {
            errorElement.remove();
        }
        field.style.borderColor = '';
    }

    // Loading state al enviar el formulario
    loginForm.addEventListener('submit', function(e) {
        const isEmailValid = validateEmail();
        const isPasswordValid = validatePassword();

        if (isEmailValid && isPasswordValid) {
            // Mostrar loading
            btnText.style.display = 'none';
            btnLoading.style.display = 'block';
            loginBtn.disabled = true;
        } else {
            e.preventDefault();
        }
    });

    // Efectos de focus en los campos
    document.querySelectorAll('.floating-label input').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });

        input.addEventListener('blur', function() {
            if (this.value === '') {
                this.parentElement.classList.remove('focused');
            }
        });

        // Inicializar estado si hay valor
        if (input.value !== '') {
            input.parentElement.classList.add('focused');
        }
    });
});
</script>
@endsection