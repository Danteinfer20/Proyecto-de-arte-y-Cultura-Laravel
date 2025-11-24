{{-- resources/views/dashboard/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard - ' . config('app.name'))

@section('content')
<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Dashboard</h1>
        <p>Bienvenido/a, {{ $basicStats['user_name'] }}!</p>
        <div class="user-badge">{{ ucfirst($basicStats['user_type']) }}</div>
    </div>

    <!-- Estadísticas Básicas -->
    <div class="stats-grid" id="stats-container">
        <div class="stat-card">
            <h3>Eventos Activos</h3>
            <p class="stat-number">{{ $basicStats['total_events'] }}</p>
        </div>
        <div class="stat-card">
            <h3>Productos</h3>
            <p class="stat-number">{{ $basicStats['total_products'] }}</p>
        </div>
        <div class="stat-card">
            <h3>Artículos</h3>
            <p class="stat-number">{{ $basicStats['total_posts'] }}</p>
        </div>
    </div>

    <!-- Contenido específico por user_type -->
    <div class="dashboard-content">
        @switch($basicStats['user_type'])
            @case('admin')
                @include('dashboard.admin')
                @break
            @case('artisan')
                @include('dashboard.artisan')
                @break
            @default
                @include('dashboard.client')
        @endswitch
    </div>
</div>
@endsection