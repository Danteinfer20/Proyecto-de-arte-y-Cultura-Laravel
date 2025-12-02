<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Event;
use App\Models\Product;
use App\Models\SavedItem;
use App\Models\EventAttendance;
use App\Models\Follow;
use App\Models\Order;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Dashboard principal - redirige según rol
     */
    public function index()
    {
        $user = Auth::user();
        
        switch($user->user_type) {
            case 'artist':
                return redirect()->route('dashboard.artist');
            case 'cultural_manager':
                return redirect()->route('dashboard.cultural-manager');
            case 'admin':
                return redirect()->route('dashboard.admin');
            case 'educator':
                return redirect()->route('dashboard.educator');
            case 'visitor':
            default:
                return redirect()->route('dashboard.visitor');
        }
    }

    /**
     * Dashboard para ARTISTAS
     */
    public function artist()
    {
        $user = Auth::user();
        
        if ($user->user_type !== 'artist') {
            abort(403, 'No tienes permisos para acceder al dashboard de artista.');
        }

        $stats = $this->getArtistStats($user);
        $data = $this->getArtistData($user);

        return view('dashboard.roles.artist', array_merge($stats, $data));
    }

    /**
     * Dashboard para GESTORES CULTURALES - CORREGIDO
     */
    public function culturalManager()
    {
        $user = Auth::user();
        
        if ($user->user_type !== 'cultural_manager') {
            abort(403, 'No tienes permisos para acceder al dashboard de gestor cultural.');
        }

        try {
            $stats = $this->getVisitorStats($user);
            $data = $this->getVisitorData($user);
            $culturalData = $this->getCulturalManagerData($user);

            return view('dashboard.roles.cultural_manager-modern', 
                        array_merge($stats, $data, $culturalData));
                        
        } catch (\Exception $e) {
            // Fallback a vista básica si hay error
            return view('dashboard.roles.cultural_manager-modern', [
                'user' => $user,
                'locations_used' => collect([]),
                'event_attendees' => collect([]),
                'total_attendees' => 0,
                'confirmed_attendees' => 0,
                'average_attendance' => 0,
                'managed_events' => 0,
                'upcoming_events' => 0,
                'saved_posts' => 0,
                'events_attended' => 0,
                'following_count' => 0
            ]);
        }
    }

    /**
     * Dashboard para ADMINISTRADORES
     */
    public function admin()
    {
        $user = Auth::user();
        
        if ($user->user_type !== 'admin') {
            abort(403, 'No tienes permisos para acceder al dashboard de administrador.');
        }

        $stats = $this->getAdminStats();
        $data = $this->getAdminData();

        return view('dashboard.roles.admin-modern', array_merge($stats, $data));
    }

    /**
     * Dashboard para VISITANTES
     */
    public function visitor()
    {
        $user = Auth::user();
        
        if (!in_array($user->user_type, ['visitor', 'educator', 'cultural_manager'])) {
            abort(403, 'No tienes permisos para acceder al dashboard de visitante.');
        }

        $stats = $this->getVisitorStats($user);
        $data = $this->getVisitorData($user);

        return view('dashboard.roles.visitor-modern', array_merge($stats, $data));
    }

    /**
     * Dashboard para EDUCADORES
     */
    public function educator()
    {
        $user = Auth::user();
        
        if ($user->user_type !== 'educator') {
            abort(403, 'No tienes permisos para acceder al dashboard de educador.');
        }

        // Usar vista visitor-modern temporalmente
        return redirect()->route('dashboard.visitor');
    }

    // =============================================
    // MÉTODOS PARA ESTADÍSTICAS DE ARTISTAS
    // =============================================

    private function getArtistStats($user)
    {
        return [
            // Estadísticas básicas
            'total_posts' => Post::where('user_id', $user->id)->count(),
            'published_posts' => Post::where('user_id', $user->id)->where('status', 'published')->count(),
            'featured_posts' => Post::where('user_id', $user->id)->where('is_featured', true)->count(),
            
            // Productos
            'total_products' => Product::where('user_id', $user->id)->count(),
            'available_products' => Product::where('user_id', $user->id)->where('status', 'available')->count(),
            'physical_products' => Product::where('user_id', $user->id)
                                       ->where('product_type', 'physical')
                                       ->count(),
            'digital_products' => Product::where('user_id', $user->id)
                                      ->where('product_type', 'digital')
                                      ->count(),
            'total_sales' => Product::where('user_id', $user->id)->sum('sales_count'),
            'total_revenue' => $this->getArtistRevenue($user->id),
            
            // Eventos
            'organized_events' => Event::where('organizer_id', $user->id)->count(),
            'upcoming_events' => Event::where('organizer_id', $user->id)
                                   ->where('start_date', '>=', now())
                                   ->where('event_status', 'scheduled')
                                   ->count(),
            
            // Social
            'follower_count' => Follow::where('followed_id', $user->id)->count(),
            'following_count' => Follow::where('follower_id', $user->id)->count(),
            'total_views' => Post::where('user_id', $user->id)->sum('view_count'),
            
            // Engagement
            'total_reactions' => DB::table('reactions')
                                ->join('posts', 'reactions.post_id', '=', 'posts.id')
                                ->where('posts.user_id', $user->id)
                                ->count(),
            'total_comments' => DB::table('comments')
                               ->join('posts', 'comments.post_id', '=', 'posts.id')
                               ->where('posts.user_id', $user->id)
                               ->count(),
        ];
    }

    private function getArtistData($user)
    {
        return [
            'recent_posts' => Post::where('user_id', $user->id)
                                ->with(['category', 'media'])
                                ->latest()
                                ->take(6)
                                ->get(),
            
            'recent_products' => Product::where('user_id', $user->id)
                                      ->with('category')
                                      ->latest()
                                      ->take(4)
                                      ->get(),
            
            'recent_events' => Event::where('organizer_id', $user->id)
                                  ->with(['post', 'location'])
                                  ->where('start_date', '>=', now())
                                  ->where('event_status', 'scheduled')
                                  ->latest()
                                  ->take(3)
                                  ->get(),
        ];
    }

    private function getArtistRevenue($userId)
    {
        try {
            return DB::table('order_items')
                    ->join('products', 'order_items.product_id', '=', 'products.id')
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->where('products.user_id', $userId)
                    ->where('orders.status', 'delivered')
                    ->selectRaw('SUM(order_items.quantity * order_items.unit_price) as total')
                    ->value('total') ?? 0;
        } catch (\Exception $e) {
            return Product::where('user_id', $userId)
                        ->sum(DB::raw('COALESCE(price * sales_count, 0)')) ?? 0;
        }
    }

    // =============================================
    // MÉTODOS PARA ESTADÍSTICAS DE GESTORES CULTURALES
    // =============================================

    private function getCulturalManagerData($user)
    {
        return [
            'locations_used' => Location::where('city', 'Popayán')->get(),
            'event_attendees' => EventAttendance::with('user')
                                ->whereHas('event', function($query) use ($user) {
                                    $query->where('organizer_id', $user->id);
                                })
                                ->latest()
                                ->take(8)
                                ->get(),
            'total_attendees' => EventAttendance::whereHas('event', function($query) use ($user) {
                                    $query->where('organizer_id', $user->id);
                                })->count(),
            'confirmed_attendees' => EventAttendance::whereHas('event', function($query) use ($user) {
                                        $query->where('organizer_id', $user->id);
                                    })->where('status', 'confirmed')->count(),
            'average_attendance' => $this->calculateAverageAttendance($user),
            'managed_events' => Event::where('organizer_id', $user->id)->count(),
            'upcoming_events' => Event::where('organizer_id', $user->id)
                                    ->where('start_date', '>=', now())
                                    ->where('event_status', 'scheduled')
                                    ->count()
        ];
    }

    private function calculateAverageAttendance($user)
    {
        $totalEvents = Event::where('organizer_id', $user->id)->count();
        if ($totalEvents === 0) return 0;

        $totalAttendees = EventAttendance::whereHas('event', function($query) use ($user) {
                                $query->where('organizer_id', $user->id);
                            })->count();

        return round(($totalAttendees / $totalEvents), 1);
    }

    // =============================================
    // MÉTODOS PARA ESTADÍSTICAS DE ADMINISTRADORES
    // =============================================

    private function getAdminStats()
    {
        return [
            // Usuarios
            'total_users' => User::count(),
            'artist_count' => User::where('user_type', 'artist')->count(),
            'manager_count' => User::where('user_type', 'cultural_manager')->count(),
            'visitor_count' => User::where('user_type', 'visitor')->count(),
            'admin_count' => User::where('user_type', 'admin')->count(),
            
            // Contenido
            'total_posts' => Post::count(),
            'published_posts' => Post::where('status', 'published')->count(),
            'draft_posts' => Post::where('status', 'draft')->count(),
            'featured_posts' => Post::where('is_featured', true)->count(),
            
            // Eventos
            'event_count' => Event::count(),
            'scheduled_events' => Event::where('event_status', 'scheduled')->count(),
            'ongoing_events' => Event::where('event_status', 'ongoing')->count(),
            
            // Productos
            'product_count' => Product::count(),
            'available_products' => Product::where('status', 'available')->count(),
            'sold_out_products' => Product::where('status', 'sold_out')->count(),
            
            // Estadísticas adicionales
            'total_revenue' => $this->getTotalRevenue(),
            'pending_reports' => 0,
            'pending_approvals' => Post::where('status', 'draft')->count(),
            'recent_comments' => DB::table('comments')->count(),
        ];
    }

    private function getTotalRevenue()
    {
        try {
            return Product::sum(DB::raw('COALESCE(price * sales_count, 0)')) ?? 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getAdminData()
    {
        return [
            'recent_users' => User::with(['posts', 'products'])
                                ->latest()
                                ->take(8)
                                ->get(),
            
            'recent_posts' => Post::with(['user', 'category'])
                                ->latest()
                                ->take(5)
                                ->get(),
        ];
    }

    // =============================================
    // MÉTODOS PARA ESTADÍSTICAS DE VISITANTES
    // =============================================

    private function getVisitorStats($user)
    {
        return [
            // Contenido guardado
            'saved_posts' => SavedItem::where('user_id', $user->id)->count(),
            'favorite_posts' => SavedItem::where('user_id', $user->id)
                                       ->where('category', 'favorites')
                                       ->count(),
            'inspiration_posts' => SavedItem::where('user_id', $user->id)
                                          ->where('category', 'inspiration')
                                          ->count(),
            
            // Participación en eventos
            'events_attended' => EventAttendance::where('user_id', $user->id)
                                              ->where('checked_in', true)
                                              ->count(),
            'events_interested' => EventAttendance::where('user_id', $user->id)
                                                ->where('status', 'interested')
                                                ->count(),
            
            // Social
            'following_count' => Follow::where('follower_id', $user->id)->count(),
            'follower_count' => Follow::where('followed_id', $user->id)->count(),
            
            // Actividad
            'comments_made' => DB::table('comments')
                               ->where('user_id', $user->id)
                               ->count(),
        ];
    }

    private function getVisitorData($user)
    {
        return [
            'saved_posts_list' => SavedItem::where('user_id', $user->id)
                                         ->with(['post.user', 'post.media', 'post.category'])
                                         ->latest()
                                         ->take(6)
                                         ->get(),
            
            'upcoming_events' => Event::with(['post', 'location'])
                                    ->where('event_status', 'scheduled')
                                    ->where('start_date', '>=', now())
                                    ->latest()
                                    ->take(4)
                                    ->get(),
        ];
    }

    /**
     * Galería del artista
     */
    public function gallery()
    {
        $user = Auth::user();
        
        if ($user->user_type !== 'artist') {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return view('dashboard.gallery', [
            'user' => $user,
            'posts' => Post::where('user_id', $user->id)
                         ->with(['media', 'category'])
                         ->latest()
                         ->get(),
            'products' => Product::where('user_id', $user->id)
                               ->with(['images', 'category'])
                               ->latest()
                               ->get()
        ]);
    }
}