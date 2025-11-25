@extends('layouts.app')

@section('title', 'Dashboard - ' . config('app.name'))

@section('content')
<div class="dashboard-container">
    <!-- Header Mejorado -->
    <div class="dashboard-header">
        <div class="user-welcome">
            <h1>Bienvenido/a, {{ Auth::user()->name }}! 👋</h1>
            <p>Gestiona tu experiencia en Arte & Cultura Popayán</p>
            <div class="user-info-badge">
                @switch(Auth::user()->user_type)
                    @case('cultural_manager')
                        <i class="fas fa-calendar-alt"></i> Gestor Cultural
                        @break
                    @case('artist')
                        <i class="fas fa-paint-brush"></i> Artista/Creador
                        @break
                    @case('visitor')
                        <i class="fas fa-heart"></i> Amante del Arte
                        @break
                    @case('admin')
                        <i class="fas fa-crown"></i> Administrador
                        @break
                @endswitch
            </div>
        </div>
        
        <div class="header-actions">
            <a href="{{ route('profile.edit') }}" class="btn btn-outline">
                <i class="fas fa-user-edit"></i>
                Mi Perfil
            </a>
        </div>
    </div>

    <!-- Estadísticas Básicas -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ $basicStats['total_events'] ?? 0 }}</h3>
                <p class="stat-label">Eventos Activos</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ $basicStats['total_products'] ?? 0 }}</h3>
                <p class="stat-label">Productos</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-newspaper"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ $basicStats['total_posts'] ?? 0 }}</h3>
                <p class="stat-label">Artículos</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">{{ $basicStats['total_users'] ?? 0 }}</h3>
                <p class="stat-label">Usuarios</p>
            </div>
        </div>
    </div>

    <!-- Contenido específico por user_type -->
    <div class="dashboard-content-section">
        <div class="section-header">
            <h2>Acciones Rápidas</h2>
            <p>Gestiona tu contenido según tu rol</p>
        </div>
        
        <div class="dashboard-actions">
            @switch(Auth::user()->user_type)
                @case('admin')
                    @include('dashboard.admin')
                    @break
                @case('cultural_manager')
                    @include('dashboard.cultural_manager')
                    @break
                @case('artist')
                    @include('dashboard.artist')
                    @break
                @case('visitor')
                    @include('dashboard.visitor')
                    @break
            @endswitch
        </div>
    </div>

    <!-- Actividad Reciente -->
    <div class="dashboard-content-section">
        <div class="section-header">
            <h2>Actividad Reciente</h2>
            <p>Tu actividad en la plataforma</p>
        </div>
        
        <div class="recent-activity">
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="activity-content">
                    <p><strong>Último acceso:</strong> {{ Auth::user()->last_login_at ? Auth::user()->last_login_at->diffForHumans() : 'Primera vez' }}</p>
                    <span class="activity-time">Cuenta creada: {{ Auth::user()->created_at->diffForHumans() }}</span>
                </div>
            </div>
            
            @if(Auth::user()->user_type === 'admin')
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="activity-content">
                    <p><strong>Estadísticas del sistema:</strong> Todo funcionando correctamente</p>
                    <span class="activity-time">Estado: Activo</span>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection