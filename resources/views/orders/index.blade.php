@extends('layouts.app')

@section('title', 'Mis Pedidos - Arte y Cultura Popayán')

@section('content')
<div class="container">
    <div class="orders-header">
        <h1>📦 Mis Pedidos</h1>
        <p>Historial de tus compras y reservas</p>
    </div>
    
    <div class="orders-content">
        <div class="empty-state">
            <div class="empty-icon">📦</div>
            <h3>No tienes pedidos aún</h3>
            <p>Cuando realices compras o reservas, aparecerán aquí.</p>
            <div class="empty-actions">
                <a href="{{ route('products.index') }}" class="btn btn-primary">Explorar Productos</a>
                <a href="{{ route('events.index') }}" class="btn btn-outline">Ver Eventos</a>
            </div>
        </div>
    </div>
</div>
@endsection