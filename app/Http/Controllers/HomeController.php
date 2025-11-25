<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Product;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Eventos destacados (próximos)
        $featuredEvents = Event::with(['post', 'category', 'location'])
            ->where('event_status', 'active')
            ->where('start_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->limit(6)
            ->get();

        // Productos artesanales destacados
        $featuredProducts = Product::with(['user', 'category', 'images'])
            ->where('status', 'active')
            ->where('stock_quantity', '>', 0)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // Artistas destacados
        $featuredArtists = User::where('user_type', 'artist')
            ->where('status', 'active')
            ->where('is_verified', true)
            ->withCount('products')
            ->orderBy('last_login_at', 'desc')
            ->limit(6)
            ->get();

        // Posts del blog cultural
        $featuredPosts = Post::with(['user', 'category'])
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->get();

        // Categorías para el home
        $categories = Category::withCount(['posts', 'products', 'events'])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        // Estadísticas para el home interactivo
        $stats = [
            'events_count' => Event::where('event_status', 'active')
                ->where('start_date', '>=', now())
                ->count(),
            'artists_count' => User::where('user_type', 'artist')
                ->where('status', 'active')
                ->count(),
            'products_count' => Product::where('status', 'active')
                ->where('stock_quantity', '>', 0)
                ->count(),
            'posts_count' => Post::where('status', 'published')
                ->where('published_at', '<=', now())
                ->count(),
        ];

        return view('home', compact(
            'featuredEvents',
            'featuredProducts', 
            'featuredArtists',
            'featuredPosts',
            'categories',
            'stats'
        ));
    }
}