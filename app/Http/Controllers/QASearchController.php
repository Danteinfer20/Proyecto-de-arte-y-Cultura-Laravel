<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Event;
use App\Models\Product;
use App\Models\User;

class QASearchController extends Controller
{
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

    public function suggestions(Request $request)
    {
        $query = $request->get('q');
        
        $suggestions = [
            'posts' => Post::where('title', 'like', "%{$query}%")
                        ->where('status', 'published')
                        ->pluck('title')
                        ->take(3),
            'events' => Event::whereHas('post', function($q) use ($query) {
                        $q->where('title', 'like', "%{$query}%");
                    })
                    ->pluck('start_date')
                    ->take(2),
            'products' => Product::where('name', 'like', "%{$query}%")
                            ->where('status', 'available')
                            ->pluck('name')
                            ->take(3),
        ];

        return response()->json($suggestions);
    }
}