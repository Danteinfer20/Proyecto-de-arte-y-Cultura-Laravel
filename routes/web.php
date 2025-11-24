<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PostController;

// Ruta principal
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rutas de autenticación
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // ⚠️ ELIMINA ESTA LÍNEA: Route::get('/profile/dashboard', [DashboardController::class, 'index'])->name('profile.dashboard');
});

// Rutas públicas
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/about', function () { 
    return view('about'); 
})->name('about');