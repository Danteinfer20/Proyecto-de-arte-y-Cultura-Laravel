<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Location;
use App\Models\Post;
use App\Models\PostMedia;
use App\Models\ContentType;
use App\Models\EventAttendance;
use App\Models\SavedItem;
use App\Models\PerformingArts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventController extends Controller
{
  public function index()
{
    $events = Event::with(['post.category', 'location', 'organizer', 'post.media'])
        ->where('event_status', 'scheduled')
        ->whereHas('post', function($query) {
            $query->where('status', 'published');
        })
        ->orderBy('start_date', 'asc')
        ->paginate(12);

    // 🔥 CORRECCIÓN: Solo categorías activas (sin category_type)
    $categories = Category::where('is_active', true)->get();

    $locations = Location::where('city', 'Popayán')->get();

    return view('events.index', compact('events', 'categories', 'locations'));
}
    public function show($id)
    {
        $event = Event::with([
            'post.category', 
            'post.media',
            'location', 
            'organizer',
            'performingArts',
            'attendances.user'
        ])->findOrFail($id);

        // Verificar que el evento esté publicado
        if ($event->post->status !== 'published' && !$this->canEditEvent($event)) {
            abort(404);
        }

        // Incrementar contador de vistas del post relacionado
        if ($event->post) {
            $event->post->increment('view_count');
        }

        // Verificar si el usuario actual está registrado en el evento
        $userAttendance = null;
        if (Auth::check()) {
            $userAttendance = EventAttendance::where('event_id', $id)
                ->where('user_id', Auth::id())
                ->first();
        }

        // Verificar si el usuario ha guardado el evento
        $isSaved = false;
        if (Auth::check()) {
            $isSaved = SavedItem::where('user_id', Auth::id())
                ->where('post_id', $event->post_id)
                ->exists();
        }

        // Eventos relacionados (misma categoría)
        $relatedEvents = Event::with(['post.category', 'location', 'post.media'])
            ->where('id', '!=', $event->id)
            ->where('event_status', 'scheduled')
            ->whereHas('post', function($query) use ($event) {
                $query->where('category_id', $event->post->category_id)
                      ->where('status', 'published');
            })
            ->orderBy('start_date', 'asc')
            ->limit(4)
            ->get();

        return view('events.show', compact('event', 'userAttendance', 'isSaved', 'relatedEvents'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        $locations = Location::all();
        $contentTypes = ContentType::where('allows_events', true)->get();
        
        return view('events.create', compact('categories', 'locations', 'contentTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'content' => 'required|string|min:50',
            'category_id' => 'required|exists:categories,id',
            'content_type_id' => 'required|exists:content_types,id',
            'location_id' => 'nullable|exists:locations,id',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'price' => 'nullable|numeric|min:0',
            'max_capacity' => 'nullable|integer|min:1',
            'event_type' => 'required|in:free,paid,donation',
            'requires_rsvp' => 'boolean',
            'event_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            
            // Campos para artes escénicas
            'art_type' => 'nullable|in:circus,theater,dance,performance,magic,music,storytelling',
            'duration_minutes' => 'nullable|integer|min:1',
            'artistic_director' => 'nullable|string|max:150',
            'company' => 'nullable|string|max:150',
            'genre' => 'nullable|string|max:100',
            'target_audience' => 'nullable|string|max:50',
            'technical_requirements' => 'nullable|string',
        ]);

        try {
            // Crear el post primero
            $post = Post::create([
                'user_id' => Auth::id(),
                'category_id' => $validated['category_id'],
                'content_type_id' => $validated['content_type_id'],
                'title' => $validated['title'],
                'slug' => $this->generateUniqueSlug($validated['title']),
                'content' => $validated['content'],
                'excerpt' => Str::limit(strip_tags($validated['content']), 150),
                'status' => 'published',
                'published_at' => now(),
                'allow_comments' => true,
            ]);

            // Crear el evento relacionado
            $event = Event::create([
                'post_id' => $post->id,
                'location_id' => $validated['location_id'],
                'organizer_id' => Auth::id(),
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'price' => $validated['price'] ?? 0,
                'max_capacity' => $validated['max_capacity'],
                'available_slots' => $validated['max_capacity'],
                'requires_rsvp' => $validated['requires_rsvp'] ?? false,
                'event_type' => $validated['event_type'],
                'event_status' => 'scheduled',
            ]);

            // Guardar imagen si se subió
            if ($request->hasFile('event_image')) {
                $this->storeEventImage($request->file('event_image'), $post->id, $validated['title']);
            }

            // Crear registro de artes escénicas si se proporcionó
            if ($request->filled('art_type')) {
                PerformingArts::create([
                    'event_id' => $event->id,
                    'art_type' => $validated['art_type'],
                    'duration_minutes' => $validated['duration_minutes'],
                    'artistic_director' => $validated['artistic_director'],
                    'company' => $validated['company'],
                    'genre' => $validated['genre'],
                    'target_audience' => $validated['target_audience'],
                    'technical_requirements' => $validated['technical_requirements'],
                    'cast_members' => $request->cast_members ? json_encode($request->cast_members) : null,
                ]);
            }

            return redirect()->route('events.show', $event->id)
                ->with('success', '🎉 Evento creado exitosamente. ¡La comunidad de Popayán lo está esperando!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', '❌ Error al crear el evento: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $event = Event::with(['post', 'post.media', 'performingArts'])->findOrFail($id);
        
        // Verificar que el usuario es el organizador o admin
        if (!$this->canEditEvent($event)) {
            abort(403, 'No tienes permisos para editar este evento.');
        }

        $categories = Category::where('is_active', true)->get();
        $locations = Location::all();
        $contentTypes = ContentType::where('allows_events', true)->get();

        return view('events.edit', compact('event', 'categories', 'locations', 'contentTypes'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::with(['post', 'post.media', 'performingArts'])->findOrFail($id);

        // Verificar que el usuario es el organizador o admin
        if (!$this->canEditEvent($event)) {
            abort(403, 'No tienes permisos para editar este evento.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'content' => 'required|string|min:50',
            'category_id' => 'required|exists:categories,id',
            'content_type_id' => 'required|exists:content_types,id',
            'location_id' => 'nullable|exists:locations,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'price' => 'nullable|numeric|min:0',
            'max_capacity' => 'nullable|integer|min:1',
            'event_type' => 'required|in:free,paid,donation',
            'event_status' => 'required|in:scheduled,ongoing,completed,cancelled',
            'requires_rsvp' => 'boolean',
            'event_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            
            // Campos para artes escénicas
            'art_type' => 'nullable|in:circus,theater,dance,performance,magic,music,storytelling',
            'duration_minutes' => 'nullable|integer|min:1',
            'artistic_director' => 'nullable|string|max:150',
            'company' => 'nullable|string|max:150',
            'genre' => 'nullable|string|max:100',
            'target_audience' => 'nullable|string|max:50',
            'technical_requirements' => 'nullable|string',
        ]);

        try {
            // Actualizar el post
            $event->post->update([
                'title' => $validated['title'],
                'category_id' => $validated['category_id'],
                'content_type_id' => $validated['content_type_id'],
                'content' => $validated['content'],
                'excerpt' => Str::limit(strip_tags($validated['content']), 150),
                'slug' => $this->generateUniqueSlug($validated['title'], $event->post->id),
            ]);

            // Actualizar el evento
            $event->update([
                'location_id' => $validated['location_id'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'price' => $validated['price'] ?? 0,
                'max_capacity' => $validated['max_capacity'],
                'event_type' => $validated['event_type'],
                'event_status' => $validated['event_status'],
                'requires_rsvp' => $validated['requires_rsvp'] ?? false,
            ]);

            // Guardar nueva imagen si se subió
            if ($request->hasFile('event_image')) {
                // Eliminar imagen anterior si existe
                if ($event->post->media->isNotEmpty()) {
                    foreach ($event->post->media as $media) {
                        Storage::disk('public')->delete($media->file_path);
                        $media->delete();
                    }
                }
                $this->storeEventImage($request->file('event_image'), $event->post_id, $validated['title']);
            }

            // Actualizar o crear artes escénicas
            if ($request->filled('art_type')) {
                if ($event->performingArts) {
                    $event->performingArts->update([
                        'art_type' => $validated['art_type'],
                        'duration_minutes' => $validated['duration_minutes'],
                        'artistic_director' => $validated['artistic_director'],
                        'company' => $validated['company'],
                        'genre' => $validated['genre'],
                        'target_audience' => $validated['target_audience'],
                        'technical_requirements' => $validated['technical_requirements'],
                        'cast_members' => $request->cast_members ? json_encode($request->cast_members) : null,
                    ]);
                } else {
                    PerformingArts::create([
                        'event_id' => $event->id,
                        'art_type' => $validated['art_type'],
                        'duration_minutes' => $validated['duration_minutes'],
                        'artistic_director' => $validated['artistic_director'],
                        'company' => $validated['company'],
                        'genre' => $validated['genre'],
                        'target_audience' => $validated['target_audience'],
                        'technical_requirements' => $validated['technical_requirements'],
                        'cast_members' => $request->cast_members ? json_encode($request->cast_members) : null,
                    ]);
                }
            } elseif ($event->performingArts) {
                // Eliminar registro de artes escénicas si ya no se necesita
                $event->performingArts->delete();
            }

            return redirect()->route('events.show', $event->id)
                ->with('success', '✅ Evento actualizado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', '❌ Error al actualizar el evento: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $event = Event::with(['post', 'post.media'])->findOrFail($id);

        // Verificar que el usuario es el organizador o admin
        if (!$this->canEditEvent($event)) {
            abort(403, 'No tienes permisos para eliminar este evento.');
        }

        try {
            // Eliminar imágenes asociadas
            if ($event->post->media->isNotEmpty()) {
                foreach ($event->post->media as $media) {
                    Storage::disk('public')->delete($media->file_path);
                }
            }

            // Eliminar el post relacionado (se elimina en cascada por la relación)
            $event->post->delete();

            return redirect()->route('events.index')
                ->with('success', '🗑️ Evento eliminado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', '❌ Error al eliminar el evento: ' . $e->getMessage());
        }
    }

    // ========== MÉTODOS PARA ASISTENCIA A EVENTOS ==========

    public function attend(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);
        $user = Auth::user();

        // Verificar que el evento esté activo
        if ($event->event_status !== 'scheduled') {
            return response()->json([
                'success' => false,
                'message' => 'Este evento no está disponible para registro.'
            ], 422);
        }

        $validated = $request->validate([
            'status' => 'required|in:confirmed,interested,not_attending',
            'guest_count' => 'nullable|integer|min:0|max:10',
        ]);

        // Verificar si hay cupos disponibles para confirmación
        if ($validated['status'] === 'confirmed') {
            $availableSlots = $event->available_slots - ($validated['guest_count'] ?? 0);
            if ($availableSlots < 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay cupos disponibles para la cantidad de invitados especificada.'
                ], 422);
            }
        }

        // Buscar asistencia existente
        $existingAttendance = EventAttendance::where('event_id', $eventId)
            ->where('user_id', $user->id)
            ->first();

        // Manejar cambio de estado y cupos
        if ($existingAttendance) {
            // Si estaba confirmado y ahora cambia, liberar cupos
            if ($existingAttendance->status === 'confirmed' && $validated['status'] !== 'confirmed') {
                $event->increment('available_slots', $existingAttendance->guest_count + 1);
            }
            
            // Si ahora se confirma y antes no estaba confirmado, ocupar cupos
            if ($validated['status'] === 'confirmed' && $existingAttendance->status !== 'confirmed') {
                $guestCount = $validated['guest_count'] ?? 0;
                $event->decrement('available_slots', $guestCount + 1);
            }

            $existingAttendance->update([
                'status' => $validated['status'],
                'guest_count' => $validated['guest_count'] ?? 0,
            ]);
            $attendance = $existingAttendance;
        } else {
            // Nueva asistencia
            if ($validated['status'] === 'confirmed') {
                $guestCount = $validated['guest_count'] ?? 0;
                $event->decrement('available_slots', $guestCount + 1);
            }

            $attendance = EventAttendance::create([
                'event_id' => $eventId,
                'user_id' => $user->id,
                'status' => $validated['status'],
                'guest_count' => $validated['guest_count'] ?? 0,
                'qr_code' => Str::random(20),
            ]);
        }

        $message = $this->getAttendanceMessage($validated['status']);

        return response()->json([
            'success' => true,
            'message' => $message,
            'attendance' => $attendance,
            'available_slots' => $event->fresh()->available_slots
        ]);
    }

    public function cancelAttendance($eventId)
    {
        $attendance = EventAttendance::where('event_id', $eventId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Liberar cupos si estaba confirmado
        if ($attendance->status === 'confirmed') {
            $event = Event::find($eventId);
            $event->increment('available_slots', $attendance->guest_count + 1);
        }

        $attendance->delete();

        return response()->json([
            'success' => true,
            'message' => 'Has cancelado tu participación en este evento.',
            'available_slots' => $event->fresh()->available_slots
        ]);
    }

    // ========== MÉTODO PARA GUARDAR EVENTOS ==========

    public function save(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);
        $user = Auth::user();

        $validated = $request->validate([
            'category' => 'nullable|in:read_later,favorites,inspiration,educational'
        ]);

        // Verificar si ya está guardado
        $existingSave = SavedItem::where('user_id', $user->id)
            ->where('post_id', $event->post_id)
            ->first();

        if ($existingSave) {
            $existingSave->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Evento removido de guardados.',
                'saved' => false
            ]);
        }

        SavedItem::create([
            'user_id' => $user->id,
            'post_id' => $event->post_id,
            'category' => $validated['category'] ?? 'favorites',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Evento guardado en tus favoritos.',
            'saved' => true
        ]);
    }

    // ========== MÉTODOS PARA CHECK-IN Y GESTIÓN ==========

    public function checkIn(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);
        
        if (!$this->canManageEvent($event)) {
            abort(403, 'No tienes permisos para realizar check-in en este evento.');
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'qr_code' => 'nullable|string'
        ]);

        $attendance = EventAttendance::where('event_id', $eventId)
            ->where('user_id', $validated['user_id'])
            ->firstOrFail();

        if ($attendance->checked_in) {
            return response()->json([
                'success' => false,
                'message' => 'Este usuario ya realizó check-in anteriormente.'
            ], 422);
        }

        $attendance->update([
            'checked_in' => true,
            'checked_in_at' => now(),
            'status' => 'attended'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-in realizado correctamente.',
            'attendance' => $attendance
        ]);
    }

    public function attendees($eventId)
    {
        $event = Event::findOrFail($eventId);
        
        if (!$this->canManageEvent($event)) {
            abort(403, 'No tienes permisos para ver la lista de asistentes.');
        }

        $attendees = EventAttendance::with('user')
            ->where('event_id', $eventId)
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total' => $attendees->count(),
            'confirmed' => $attendees->where('status', 'confirmed')->count(),
            'checked_in' => $attendees->where('checked_in', true)->count(),
            'interested' => $attendees->where('status', 'interested')->count(),
        ];

        return response()->json([
            'success' => true,
            'attendees' => $attendees,
            'stats' => $stats
        ]);
    }

    // ========== MÉTODOS PARA VISTAS ESPECIALES ==========

    public function myEvents()
    {
        $user = Auth::user();
        
        $organizedEvents = Event::with(['post', 'location', 'post.media'])
            ->where('organizer_id', $user->id)
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        $attendedEvents = EventAttendance::with(['event.post', 'event.location', 'event.post.media'])
            ->where('user_id', $user->id)
            ->where('checked_in', true)
            ->orderBy('checked_in_at', 'desc')
            ->paginate(10);

        return view('events.my-events', compact('organizedEvents', 'attendedEvents'));
    }

    public function savedEvents()
    {
        $user = Auth::user();
        
        $savedEvents = SavedItem::with(['post.event.location', 'post.event.organizer', 'post.media'])
            ->where('user_id', $user->id)
            ->whereHas('post.event')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('events.saved', compact('savedEvents'));
    }

    // ========== MÉTODOS PARA ADMIN ==========

    public function adminIndex()
    {
        if (!$this->isAdmin()) {
            abort(403);
        }

        $events = Event::with(['post', 'location', 'organizer', 'post.media'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total' => Event::count(),
            'scheduled' => Event::where('event_status', 'scheduled')->count(),
            'ongoing' => Event::where('event_status', 'ongoing')->count(),
            'completed' => Event::where('event_status', 'completed')->count(),
        ];

        return view('admin.events.index', compact('events', 'stats'));
    }

    public function adminUpdateStatus(Request $request, $id)
    {
        if (!$this->isAdmin()) {
            abort(403);
        }

        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:scheduled,ongoing,completed,cancelled'
        ]);

        $event->update(['event_status' => $validated['status']]);

        return response()->json([
            'success' => true,
            'message' => 'Estado del evento actualizado.',
            'event' => $event
        ]);
    }

    // ========== MÉTODOS AUXILIARES PRIVADOS ==========

    private function generateUniqueSlug($title, $excludeId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (Post::where('slug', $slug)
            ->when($excludeId, function($query) use ($excludeId) {
                $query->where('id', '!=', $excludeId);
            })
            ->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        return $slug;
    }

    private function storeEventImage($imageFile, $postId, $title)
    {
        $imagePath = $imageFile->store('events/' . date('Y/m'), 'public');
        
        PostMedia::create([
            'post_id' => $postId,
            'file_type' => 'image',
            'file_path' => $imagePath,
            'file_name' => $imageFile->getClientOriginalName(),
            'file_size' => $imageFile->getSize(),
            'is_cover' => true,
            'alt_text' => $title,
            'sort_order' => 0,
        ]);
    }

    private function canEditEvent($event)
    {
        return Auth::check() && (
            $event->organizer_id === Auth::id() || 
            $this->isAdmin() ||
            Auth::user()->user_type === 'cultural_manager'
        );
    }

    private function canManageEvent($event)
    {
        return Auth::check() && (
            $event->organizer_id === Auth::id() || 
            $this->isAdmin()
        );
    }

    private function isAdmin()
    {
        return Auth::check() && Auth::user()->user_type === 'admin';
    }

    private function getAttendanceMessage($status)
    {
        $messages = [
            'confirmed' => '🎉 ¡Confirmado! Te esperamos en el evento.',
            'interested' => '👍 ¡Genial! Has mostrado interés en este evento.',
            'not_attending' => '😔 Lamentamos que no puedas asistir.'
        ];

        return $messages[$status] ?? 'Estado actualizado.';
    }

    // ========== MÉTODOS PARA BÚSQUEDA Y FILTROS ==========

    public function search(Request $request)
    {
        $query = Event::with(['post.category', 'location', 'organizer', 'post.media'])
            ->where('event_status', 'scheduled')
            ->whereHas('post', function($q) use ($request) {
                $q->where('status', 'published');
            });

        if ($request->has('q') && $request->q) {
            $searchTerm = $request->q;
            $query->whereHas('post', function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('content', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->has('category') && $request->category) {
            $query->whereHas('post', function($q) use ($request) {
                $q->where('category_id', $request->category);
            });
        }

        if ($request->has('location') && $request->location) {
            $query->where('location_id', $request->location);
        }

        if ($request->has('date') && $request->date) {
            $query->whereDate('start_date', $request->date);
        }

        $events = $query->orderBy('start_date', 'asc')->paginate(12);

        return view('events.index', compact('events'));
    }
}