@extends('layouts.app')

@section('title', 'Blog Cultural - Arte y Cultura Popayán')

@section('content')
<div class="container">
    <div class="posts-header">
        <h1>📝 Blog Cultural</h1>
        <p>Artículos, noticias y historias de Popayán</p>
    </div>
    
    <div class="posts-grid">
        <div class="empty-state">
            <div class="empty-icon">📝</div>
            <h3>Próximamente artículos</h3>
            <p>Estamos preparando contenido exclusivo sobre la cultura payanesa.</p>
        </div>
    </div>
</div>
@endsection