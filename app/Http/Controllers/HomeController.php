<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Product;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 🔥 EVENTOS DESTACADOS - Actualizado para tu estructura
        $featuredEvents = Event::with([
                'post.category', 
                'location', 
                'organizer'
            ])
            ->where('event_status', 'scheduled')
            ->where('start_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->limit(6)
            ->get();

        // 🔥 PRODUCTOS DESTACADOS - Actualizado para tu estructura
        $featuredProducts = Product::with([
                'user', 
                'category'
            ])
            ->where('status', 'available')
            ->where('stock_quantity', '>', 0)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // 🔥 ARTISTAS DESTACADOS - Actualizado para tu estructura
        $featuredArtists = User::where('user_type', 'artist')
            ->where('status', 'active')
            ->where('is_verified', true)
            ->withCount(['posts', 'products'])
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // 🔥 POSTS DEL BLOG - Actualizado para tu estructura
        $featuredPosts = Post::with([
                'user', 
                'category',
                'contentType'
            ])
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->get();

        // 🔥 CATEGORÍAS - Actualizado para tu estructura
        $categories = Category::withCount([
                'posts' => function($query) {
                    $query->where('status', 'published');
                },
                'products' => function($query) {
                    $query->where('status', 'available');
                },
                'events' => function($query) {
                    $query->where('event_status', 'scheduled');
                }
            ])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // 🔥 ESTADÍSTICAS ACTUALIZADAS para el home interactivo
        $stats = [
            'events_count' => Event::where('event_status', 'scheduled')
                ->where('start_date', '>=', now())
                ->count(),
            'artists_count' => User::where('user_type', 'artist')
                ->where('status', 'active')
                ->count(),
            'products_count' => Product::where('status', 'available')
                ->where('stock_quantity', '>', 0)
                ->count(),
            'locations_count' => Location::count(), // 🔥 NUEVO - Lugares culturales
            'posts_count' => Post::where('status', 'published')
                ->where('published_at', '<=', now())
                ->count(),
        ];

        return view('front.home', compact(
            'featuredEvents',
            'featuredProducts', 
            'featuredArtists',
            'featuredPosts',
            'categories',
            'stats'
        ));
    }

    // 🔥 NUEVO MÉTODO PARA BÚSQUEDA Q&A (opcional)
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        // Búsqueda en posts
        $posts = Post::where('title', 'like', "%{$query}%")
                    ->orWhere('content', 'like', "%{$query}%")
                    ->orWhere('excerpt', 'like', "%{$query}%")
                    ->with(['user', 'category'])
                    ->where('status', 'published')
                    ->get();

        // Búsqueda en eventos
        $events = Event::whereHas('post', function($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('content', 'like', "%{$query}%");
                })
                ->with(['post', 'location'])
                ->where('event_status', 'scheduled')
                ->get();

        // Búsqueda en productos
        $products = Product::where('name', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%")
                        ->with(['user', 'category'])
                        ->where('status', 'available')
                        ->get();

        // Búsqueda en artistas
        $artists = User::where('name', 'like', "%{$query}%")
                    ->orWhere('bio', 'like', "%{$query}%")
                    ->where('user_type', 'artist')
                    ->where('status', 'active')
                    ->get();

        return view('search.results', [
            'query' => $query,
            'posts' => $posts,
            'events' => $events,
            'products' => $products,
            'artists' => $artists
        ]);
    }

    // 🔥 NUEVO MÉTODO PARA SUGERENCIAS Q&A (API)
    public function suggestions(Request $request)
    {
        $query = $request->get('q');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $suggestions = [
            'posts' => Post::where('title', 'like', "%{$query}%")
                        ->where('status', 'published')
                        ->pluck('title')
                        ->take(3)
                        ->toArray(),
            'events' => Event::whereHas('post', function($q) use ($query) {
                        $q->where('title', 'like', "%{$query}%");
                    })
                    ->with('post')
                    ->get()
                    ->pluck('post.title')
                    ->take(2)
                    ->toArray(),
            'products' => Product::where('name', 'like', "%{$query}%")
                            ->where('status', 'available')
                            ->pluck('name')
                            ->take(3)
                            ->toArray(),
            'artists' => User::where('name', 'like', "%{$query}%")
                        ->where('user_type', 'artist')
                        ->pluck('name')
                        ->take(2)
                        ->toArray(),
        ];

        // Combinar todas las sugerencias
        $allSuggestions = array_merge(
            $suggestions['posts'],
            $suggestions['events'], 
            $suggestions['products'],
            $suggestions['artists']
        );

        return response()->json(array_slice($allSuggestions, 0, 5));
    }
}
