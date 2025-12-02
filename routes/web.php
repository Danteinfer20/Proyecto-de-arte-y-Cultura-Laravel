<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

// =====================================================
// RUTAS PÚBLICAS
// =====================================================

// Ruta principal
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rutas de autenticación
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Páginas estáticas
Route::get('/about', function () { 
    return view('about'); 
})->name('about');

// Rutas de búsqueda Q&A
Route::get('/search', [HomeController::class, 'search'])->name('qa.search');
Route::get('/search/suggestions', [HomeController::class, 'suggestions'])->name('qa.suggestions');

// =====================================================
// RUTAS PÚBLICAS DE CONTENIDO (ORDEN CORREGIDO)
// =====================================================

// Events - ORDEN CORREGIDO
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Products - ORDEN CORREGIDO
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Posts - ORDEN CORREGIDO
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// Users
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

// =====================================================
// RUTAS PROTEGIDAS (Requieren autenticación)
// =====================================================

Route::middleware(['auth'])->group(function () {
    
    // ========== PERFIL DE USUARIO ==========
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // ========== DASHBOARDS POR ROL ==========
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/artist', [DashboardController::class, 'artist'])->name('dashboard.artist');
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    Route::get('/dashboard/cultural-manager', [DashboardController::class, 'culturalManager'])->name('dashboard.cultural-manager');
    Route::get('/dashboard/visitor', [DashboardController::class, 'visitor'])->name('dashboard.visitor');
    Route::get('/dashboard/educator', [DashboardController::class, 'educator'])->name('dashboard.educator');
    
    // Galería del artista
    Route::get('/artist/gallery', [DashboardController::class, 'gallery'])->name('artist.gallery');
    
    // ========== GESTIÓN DE CONTENIDO ==========
    
    // Posts (Obras/Contenido) - ORDEN CORREGIDO
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    
    // Products (Productos/Artesanías) - ORDEN CORREGIDO
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    
    // Events (Eventos) - ORDEN CORREGIDO
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    
    // Guardar eventos (Q&A)
    Route::post('/events/{event}/save', [EventController::class, 'save'])->name('events.save');
    
    // ========== GESTIÓN DE ESPACIOS ==========
    Route::get('/locations', function () {
        return view('locations.index');
    })->name('locations.index');
});

// =====================================================
// RUTAS DE ADMINISTRACIÓN (Solo para admins)
// =====================================================

Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    // ========== GESTIÓN DE USUARIOS ==========
    Route::get('/users', [UserController::class, 'adminIndex'])->name('admin.users');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    
    // ========== MODERACIÓN DE CONTENIDO ==========
    Route::get('/posts', [PostController::class, 'adminIndex'])->name('admin.posts');
    Route::get('/events', [EventController::class, 'adminIndex'])->name('admin.events');
    Route::get('/products', [ProductController::class, 'adminIndex'])->name('admin.products');
    
    // ========== ANALYTICS Y REPORTES ==========
    Route::get('/analytics', [DashboardController::class, 'analytics'])->name('admin.analytics');
    Route::get('/reports', [DashboardController::class, 'reports'])->name('admin.reports');
    
    // ========== CONFIGURACIÓN ==========
    Route::get('/settings', [DashboardController::class, 'settings'])->name('admin.settings');
    Route::get('/moderate', [DashboardController::class, 'moderate'])->name('admin.moderate');
});

// =====================================================
// RUTA DE FALLBACK (Manejo de errores 404)
// =====================================================

Route::fallback(function () {
    return redirect()->route('home');
});