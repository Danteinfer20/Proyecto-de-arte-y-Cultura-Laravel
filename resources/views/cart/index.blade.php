@extends('layouts.app')

@section('title', 'Carrito - Arte y Cultura Popayán')

@section('content')
<div class="container">
    <div class="cart-header">
        <h1>🛒 Mi Carrito</h1>
        <p>Revisa y gestiona tus productos</p>
    </div>
    
    <div class="cart-content">
        <div class="empty-state">
            <div class="empty-icon">🛒</div>
            <h3>Tu carrito está vacío</h3>
            <p>Agrega algunos productos artesanales a tu carrito.</p>
            <div class="empty-actions">
                <a href="{{ route('products.index') }}" class="btn btn-primary">Explorar Productos</a>
            </div>
        </div>
    </div>
</div>
@endsection