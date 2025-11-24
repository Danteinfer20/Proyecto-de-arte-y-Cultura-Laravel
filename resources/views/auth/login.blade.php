@extends('layouts.app')

@section('title', 'Iniciar Sesión - Arte & Cultura Popayán')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Iniciar Sesión</h1>
            <p>Accede a tu cuenta para explorar la cultura de Popayán</p>
        </div>

        <!-- Mostrar mensaje de éxito después del registro -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf
            
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group checkbox-group">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Recordar sesión</label>
            </div>

            <button type="submit" class="btn btn-primary btn-full">Iniciar Sesión</button>
        </form>

        <div class="auth-footer">
            <p>¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
            <p><a href="{{ url('/forgot-password') }}">¿Olvidaste tu contraseña?</a></p>
        </div>
    </div>
</div>
@endsection