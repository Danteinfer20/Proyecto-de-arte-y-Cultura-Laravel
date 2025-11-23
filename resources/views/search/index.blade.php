@extends('layouts.app')

@section('title', 'Buscar - Arte y Cultura Popayán')

@section('content')
<div class="container">
    <div class="search-header">
        <h1>🔍 Resultados de Búsqueda</h1>
        <p>Buscando: "{{ $query ?? 'término de búsqueda' }}"</p>
    </div>
    
    <div class="search-results">
        <div class="empty-state">
            <div class="empty-icon">🔍</div>
            <h3>No se encontraron resultados</h3>
            <p>Intenta con otros términos de búsqueda.</p>
        </div>
    </div>
</div>
@endsection
