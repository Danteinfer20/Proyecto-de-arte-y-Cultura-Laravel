<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Product;
use App\Models\Category;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $featuredEvents = Event::with(['post', 'location'])
            ->where('event_status', 'scheduled')
            ->orderBy('start_date')
            ->take(4)
            ->get();

        $featuredProducts = Product::with('category')
            ->where('is_featured', true)
            ->where('status', 'available')
            ->take(6)
            ->get();

        $categories = Category::withCount(['posts', 'products'])
            ->where('is_active', true)
            ->get();

        $stats = [
            'total_events' => Event::count(),
            'total_products' => Product::count(),
            'total_posts' => Post::count(),
        ];

        return view('home', compact(
            'featuredEvents',
            'featuredProducts', 
            'categories',
            'stats'
        ));
    }
}