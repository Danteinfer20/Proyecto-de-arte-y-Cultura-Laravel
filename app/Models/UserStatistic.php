<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_count',
        'follower_count', 
        'following_count',
        'event_count',
        'attendance_count',
        'average_rating',
        'sales_count',
        'total_revenue',
        'educational_content_count' // CORRECCIÓN: Campo agregado
    ];

    protected $casts = [
        'post_count' => 'integer',
        'follower_count' => 'integer',
        'following_count' => 'integer',
        'event_count' => 'integer',
        'attendance_count' => 'integer',
        'average_rating' => 'decimal:2',
        'sales_count' => 'integer',
        'total_revenue' => 'decimal:2',
        'educational_content_count' => 'integer',
    ];

    /* ============================
     *    RELACIONES
     * ============================ */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /* ============================
     *    MÉTODOS ÚTILES
     * ============================ */

    public function getTotalEngagementAttribute(): int
    {
        return $this->post_count + $this->event_count + $this->educational_content_count;
    }

    public function getPopularityScoreAttribute(): float
    {
        $engagement = $this->getTotalEngagementAttribute();
        $followers = $this->follower_count;
        
        if ($engagement === 0) return 0;
        
        return min(100, ($followers / $engagement) * 100);
    }

    public function getActivityLevelAttribute(): string
    {
        $total = $this->getTotalEngagementAttribute();
        
        if ($total >= 100) return '🔥 Muy activo';
        if ($total >= 50) return '⭐ Activo';
        if ($total >= 10) return '📈 Moderado';
        return '🌱 Principiante';
    }

    public function getSuccessRateAttribute(): ?float
    {
        if ($this->event_count === 0) return null;
        
        return min(100, ($this->attendance_count / max(1, $this->event_count)) * 100);
    }

    public function hasEducationalContent(): bool
    {
        return $this->educational_content_count > 0;
    }

    public function isContentCreator(): bool
    {
        return $this->post_count > 0 || $this->educational_content_count > 0;
    }

    public function isEventOrganizer(): bool
    {
        return $this->event_count > 0;
    }

    public function isSeller(): bool
    {
        return $this->sales_count > 0;
    }

    public function getContentDiversityScore(): float
    {
        $contentTypes = 0;
        
        if ($this->post_count > 0) $contentTypes++;
        if ($this->educational_content_count > 0) $contentTypes++;
        if ($this->event_count > 0) $contentTypes++;
        
        return ($contentTypes / 3) * 100;
    }

    /* ============================
     *    MÉTODOS DE ACTUALIZACIÓN
     * ============================ */

    public function incrementPostCount(): void
    {
        $this->increment('post_count');
    }

    public function decrementPostCount(): void
    {
        if ($this->post_count > 0) {
            $this->decrement('post_count');
        }
    }

    public function incrementFollowerCount(): void
    {
        $this->increment('follower_count');
    }

    public function decrementFollowerCount(): void
    {
        if ($this->follower_count > 0) {
            $this->decrement('follower_count');
        }
    }

    public function incrementEventCount(): void
    {
        $this->increment('event_count');
    }

    public function decrementEventCount(): void
    {
        if ($this->event_count > 0) {
            $this->decrement('event_count');
        }
    }

    public function incrementAttendanceCount(): void
    {
        $this->increment('attendance_count');
    }

    public function incrementSalesCount(int $quantity = 1): void
    {
        $this->increment('sales_count', $quantity);
    }

    public function addRevenue(float $amount): void
    {
        $this->increment('total_revenue', $amount);
    }

    public function incrementEducationalContentCount(): void
    {
        $this->increment('educational_content_count');
    }

    public function decrementEducationalContentCount(): void
    {
        if ($this->educational_content_count > 0) {
            $this->decrement('educational_content_count');
        }
    }

    public function updateAverageRating(float $newRating): void
    {
        // Esta sería una implementación más compleja en la realidad
        // Por simplicidad, actualizamos directamente
        $this->update(['average_rating' => $newRating]);
    }

    /* ============================
     *    SCOPES
     * ============================ */

    public function scopePopular($query)
    {
        return $query->where('follower_count', '>=', 100)
                    ->orderBy('follower_count', 'desc');
    }

    public function scopeActive($query)
    {
        return $query->where('post_count', '>=', 5)
                    ->orWhere('event_count', '>=', 3)
                    ->orWhere('educational_content_count', '>=', 3);
    }

    public function scopeContentCreators($query)
    {
        return $query->where('post_count', '>', 0)
                    ->orWhere('educational_content_count', '>', 0);
    }

    public function scopeEventOrganizers($query)
    {
        return $query->where('event_count', '>', 0);
    }

    public function scopeSellers($query)
    {
        return $query->where('sales_count', '>', 0);
    }

    public function scopeWithHighRevenue($query, float $minRevenue = 100000)
    {
        return $query->where('total_revenue', '>=', $minRevenue);
    }

    public function scopeEducationalContributors($query)
    {
        return $query->where('educational_content_count', '>', 0);
    }

    /* ============================
     *    MÉTODOS ESTÁTICOS
     * ============================ */

    public static function initializeForUser(User $user): self
    {
        return self::create([
            'user_id' => $user->id,
            'post_count' => 0,
            'follower_count' => 0,
            'following_count' => 0,
            'event_count' => 0,
            'attendance_count' => 0,
            'average_rating' => 0.00,
            'sales_count' => 0,
            'total_revenue' => 0.00,
            'educational_content_count' => 0,
        ]);
    }

    public static function getTopContributors(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return self::with('user')
                  ->orderBy('post_count', 'desc')
                  ->orderBy('educational_content_count', 'desc')
                  ->limit($limit)
                  ->get();
    }

    /* ============================
     *    HOOKS
     * ============================ */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($statistic) {
            // Inicializar valores por defecto
            $defaults = [
                'post_count' => 0,
                'follower_count' => 0,
                'following_count' => 0,
                'event_count' => 0,
                'attendance_count' => 0,
                'average_rating' => 0.00,
                'sales_count' => 0,
                'total_revenue' => 0.00,
                'educational_content_count' => 0,
            ];

            foreach ($defaults as $field => $value) {
                if (is_null($statistic->$field)) {
                    $statistic->$field = $value;
                }
            }
        });
    }
}