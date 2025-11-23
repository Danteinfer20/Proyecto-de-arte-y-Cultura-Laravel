<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with(['category', 'location', 'user'])
            ->where('status', 'active')
            ->orderBy('start_date', 'asc')
            ->paginate(9);

        $categories = Category::where('type', 'event')
            ->where('is_active', true)
            ->get();

        return view('events.index', compact('events', 'categories'));
    }

    public function show($id)
    {
        $event = Event::with(['category', 'location', 'user'])
            ->findOrFail($id);

        // Incrementar contador de vistas
        $event->increment('view_count');

        return view('events.show', compact('event'));
    }
}