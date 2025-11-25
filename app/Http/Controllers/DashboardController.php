<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Redirigir según el tipo de usuario
        switch ($user->user_type) {
            case 'admin':
                return redirect()->route('dashboard.admin');
            case 'artist':
                return redirect()->route('dashboard.artist');
            case 'cultural_manager':
                return redirect()->route('dashboard.cultural-manager');
            case 'visitor':
                return redirect()->route('dashboard.visitor');
            default:
                return redirect()->route('dashboard.visitor');
        }
    }
    
    public function artist()
    {
        $user = Auth::user();
        $posts = $user->posts ?? collect();
        $products = $user->products ?? collect();
        $events = $user->events ?? collect();
        
        return view('dashboard.artist', compact('posts', 'products', 'events'));
    }
    
    public function admin()
    {
        return view('dashboard.admin');
    }
    
    public function culturalManager()
    {
        return view('dashboard.cultural_manager');
    }
    
    public function visitor()
    {
        return view('dashboard.visitor');
    }
    
    public function gallery()
    {
        $user = Auth::user();
        $posts = $user->posts ?? collect();
        
        return view('artist.gallery', compact('posts'));
    }
}