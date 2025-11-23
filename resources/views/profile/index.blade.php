@extends('layouts.app')

@section('title', 'Mi Perfil - Arte y Cultura Popayán')

@section('content')
<div class="container">
    <div class="profile-header">
        <div class="profile-avatar">
            <div class="avatar">👤</div>
            <h1>Mi Perfil</h1>
        </div>
    </div>
    
    <div class="profile-content">
        <div class="profile-sidebar">
            <nav class="profile-nav">
                <a href="#info" class="nav-item active">📋 Información</a>
                <a href="#security" class="nav-item">🔒 Seguridad</a>
                <a href="{{ route('orders.index') }}" class="nav-item">📦 Pedidos</a>
                <a href="{{ route('saved.items') }}" class="nav-item">❤️ Guardados</a>
            </nav>
        </div>
        
        <div class="profile-main">
            <section id="info" class="profile-section active">
                <h2>Información Personal</h2>
                <form class="profile-form">
                    <div class="form-group">
                        <label>Nombre completo</label>
                        <input type="text" value="Usuario Ejemplo" readonly>
                    </div>
                    <div class="form-group">
                        <label>Correo electrónico</label>
                        <input type="email" value="usuario@ejemplo.com" readonly>
                    </div>
                    <button type="button" class="btn btn-outline">Editar Perfil</button>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection