<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'tag_type',
        'usage_count',
        'description',
        'color'
    ];

    protected $casts = [
        'usage_count' => 'integer',
    ];

    /* ============================
     *    RELACIONES
     * ============================ */

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_tags');
    }

    /* ============================
     *    TIPOS DE TAGS
     * ============================ */

    public static function getTagTypes(): array
    {
        return [
            'art' => '🎨 Arte',
            'place' => '📍 Lugar',
            'technique' => '🛠️ Técnica',
            'era' => '⏳ Época',
            'general' => '🏷️ General',
            'educational' => '🎓 Educativo',
        ];
    }

    /* ============================
     *    MÉTODOS ÚTILES
     * ============================ */

    public function getTagTypeNameAttribute(): string
    {
        return self::getTagTypes()[$this->tag_type] ?? $this->tag_type;
    }

    public function isArt(): bool
    {
        return $this->tag_type === 'art';
    }

    public function isPlace(): bool
    {
        return $this->tag_type === 'place';
    }

    public function isTechnique(): bool
    {
        return $this->tag_type === 'technique';
    }

    public function isEra(): bool
    {
        return $this->tag_type === 'era';
    }

    public function isEducational(): bool
    {
        return $this->tag_type === 'educational';
    }

    public function incrementUsageCount(): void
    {
        $this->increment('usage_count');
    }

    public function decrementUsageCount(): void
    {
        if ($this->usage_count > 0) {
            $this->decrement('usage_count');
        }
    }

    public function getPopularityAttribute(): string
    {
        if ($this->usage_count >= 100) {
            return '🔥 Muy popular';
        } elseif ($this->usage_count >= 50) {
            return '⭐ Popular';
        } elseif ($this->usage_count >= 10) {
            return '📈 En crecimiento';
        } else {
            return '🌱 Nuevo';
        }
    }

    public function hasColor(): bool
    {
        return !empty($this->color);
    }

    public function getDefaultColor(): string
    {
        $colors = [
            'art' => '#e74c3c',
            'place' => '#3498db',
            'technique' => '#2ecc71',
            'era' => '#f39c12',
            'educational' => '#9b59b6',
            'general' => '#95a5a6',
        ];

        return $colors[$this->tag_type] ?? '#95a5a6';
    }

    public function getDisplayColorAttribute(): string
    {
        return $this->color ?? $this->getDefaultColor();
    }

    /* ============================
     *    GESTIÓN DE SLUG
     * ============================ */

    public static function generateSlug(string $name): string
    {
        $slug = strtolower(trim($name));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        
        return $slug;
    }

    /* ============================
     *    SCOPES
     * ============================ */

    public function scopeByType($query, string $type)
    {
        return $query->where('tag_type', $type);
    }

    public function scopeArt($query)
    {
        return $this->scopeByType($query, 'art');
    }

    public function scopePlaces($query)
    {
        return $this->scopeByType($query, 'place');
    }

    public function scopeTechniques($query)
    {
        return $this->scopeByType($query, 'technique');
    }

    public function scopeEras($query)
    {
        return $this->scopeByType($query, 'era');
    }

    public function scopeEducational($query)
    {
        return $this->scopeByType($query, 'educational');
    }

    public function scopePopular($query, int $minUsage = 10)
    {
        return $query->where('usage_count', '>=', $minUsage);
    }

    public function scopeTrending($query)
    {
        return $query->where('usage_count', '>=', 5)
                    ->orderBy('usage_count', 'desc');
    }

    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeSearch($query, string $search)
    {
        return $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
    }

    /* ============================
     *    MÉTODOS ESTÁTICOS
     * ============================ */

    public static function findOrCreate(string $name, string $type = 'general'): self
    {
        $slug = self::generateSlug($name);
        
        $tag = self::where('slug', $slug)->first();
        
        if (!$tag) {
            $tag = self::create([
                'name' => $name,
                'slug' => $slug,
                'tag_type' => $type,
                'usage_count' => 0,
            ]);
        }
        
        return $tag;
    }

    public static function getPopularTags(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return self::popular()->orderBy('usage_count', 'desc')->limit($limit)->get();
    }

    public static function getTagsByType(string $type, int $limit = 20): \Illuminate\Database\Eloquent\Collection
    {
        return self::byType($type)->orderBy('usage_count', 'desc')->limit($limit)->get();
    }

    /* ============================
     *    HOOKS
     * ============================ */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            if (empty($tag->slug)) {
                $tag->slug = self::generateSlug($tag->name);
            }
            if (empty($tag->tag_type)) {
                $tag->tag_type = 'general';
            }
            if (is_null($tag->usage_count)) {
                $tag->usage_count = 0;
            }
        });
    }
}