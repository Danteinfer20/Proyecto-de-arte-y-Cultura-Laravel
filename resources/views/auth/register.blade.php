@extends('layouts.app')

@section('title', 'Registrarse - Arte & Cultura Popayán')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Crear Cuenta</h1>
            <p>Únete a nuestra comunidad cultural</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="auth-form">
            @csrf
            
            <div class="form-group">
                <label for="name">Nombre Completo</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
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

            <div class="form-group">
                <label for="password_confirmation">Confirmar Contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <div class="form-group">
                <label for="user_type">Tipo de Usuario</label>
                <select id="user_type" name="user_type" required>
                    <option value="">Selecciona tu perfil</option>
                    <option value="art_lover" {{ old('user_type') == 'art_lover' ? 'selected' : '' }}>Amante del Arte</option>
                    <option value="artist" {{ old('user_type') == 'artist' ? 'selected' : '' }}>Artista/Creador</option>
                    <option value="artisan" {{ old('user_type') == 'artisan' ? 'selected' : '' }}>Artesano</option>
                    <option value="cultural_manager" {{ old('user_type') == 'cultural_manager' ? 'selected' : '' }}>Gestor Cultural</option>
                </select>
                @error('user_type')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group checkbox-group">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">Acepto los <a href="{{ url('/terms') }}">términos y condiciones</a></label>
                @error('terms')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-full">Crear Cuenta</button>
        </form>

        <div class="auth-footer">
            <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia Sesión</a></p>
        </div>
    </div>
</div>
@endsection