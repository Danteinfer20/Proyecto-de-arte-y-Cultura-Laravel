<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Product;
use App\Models\User;
use App\Models\Post;

class DashboardController extends Controller
{
    /**
     * Display the dashboard page (TRADICIONAL - HTML)
     */
    public function index()
    {
        $user = auth()->user();
        $basicStats = $this->getBasicStats();
        
        // Vista según tipo de usuario
        switch($user->user_type) {
            case 'admin':
                return view('dashboard.admin', compact('basicStats'));
            case 'artisan':
                return view('dashboard.artisan', compact('basicStats'));
            case 'client':
            default:
                return view('dashboard.client', compact('basicStats'));
        }
    }
    
    /**
     * Datos básicos para el dashboard (LO USARÁN HTML Y API)
     */
    private function getBasicStats()
    {
        $user = auth()->user();
        
        return [
            'total_events' => Event::count(),
            'total_products' => Product::count(),
            'total_posts' => Post::count(),
            'user_type' => $user->user_type,
            'user_name' => $user->name,
        ];
    }
}