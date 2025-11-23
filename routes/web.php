<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Ruta principal
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rutas de autenticación
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// ✅ AGREGAR ESTA RUTA POST PARA REGISTER
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Resto de rutas...
Route::get('/events', function () {
    return view('events.index');
})->name('events.index');

Route::get('/products', function () {
    return view('products.index');
})->name('products.index');

Route::get('/posts', function () {
    return view('posts.index');
})->name('posts.index');

Route::get('/about', function () {
    return view('about');
})->name('about');