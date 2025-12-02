@extends('layouts.app')

@section('title', 'Mapa del Sitio - Arte y Cultura Popayán')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>🗺️ Mapa del Sitio</h1>
    </div>
    
    <div class="sitemap-content">
        <div class="sitemap-section">
            <h2>🌐 Navegación Principal</h2>
            <ul>
                <li><a href="{{ route('home') }}">Inicio</a></li>
                <li><a href="{{ route('events.index') }}">Eventos</a></li>
                <li><a href="{{ route('products.index') }}">Productos</a></li>
                <li><a href="{{ route('posts.index') }}">Blog</a></li>
                <li><a href="{{ route('about') }}">Nosotros</a></li>
                
            </ul>
        </div>
    </div>
</div>
@endsection