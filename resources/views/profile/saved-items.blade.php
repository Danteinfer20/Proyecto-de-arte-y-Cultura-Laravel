@extends('layouts.app')

@section('title', 'Guardados - Arte y Cultura Popayán')

@section('content')
<div class="container">
    <div class="saved-header">
        <h1>❤️ Elementos Guardados</h1>
        <p>Tus eventos, productos y artículos favoritos</p>
    </div>
    
    <div class="saved-filters">
        <button class="filter-btn active">Todos</button>
        <button class="filter-btn">Eventos</button>
        <button class="filter-btn">Productos</button>
        <button class="filter-btn">Artículos</button>
    </div>
    
    <div class="saved-content">
        <div class="empty-state">
            <div class="empty-icon">❤️</div>
            <h3>No tienes elementos guardados</h3>
            <p>Cuando encuentres contenido que te guste, guárdalo aquí para verlo después.</p>
            <div class="empty-actions">
                <a href="{{ route('events.index') }}" class="btn btn-primary">Explorar Eventos</a>
                <a href="{{ route('products.index') }}" class="btn btn-outline">Ver Productos</a>
            </div>
        </div>
    </div>
</div>
@endsection