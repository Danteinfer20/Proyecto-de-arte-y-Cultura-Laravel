<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'allows_events',
        'allows_education',
        'icon',
        'is_active'
    ];

    protected $casts = [
        'allows_events' => 'boolean',
        'allows_education' => 'boolean',
        'is_active' => 'boolean',
    ];

    /* ============================
     *    RELACIONES
     * ============================ */

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /* ============================
     *    MÉTODOS ÚTILES
     * ============================ */

    public function allowsEvents(): bool
    {
        return $this->allows_events;
    }

    public function allowsEducation(): bool
    {
        return $this->allows_education;
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function getUsageCountAttribute(): int
    {
        return $this->posts()->count();
    }

    public function canBeUsedForEvents(): bool
    {
        return $this->allows_events && $this->is_active;
    }

    public function canBeUsedForEducation(): bool
    {
        return $this->allows_education && $this->is_active;
    }

    /* ============================
     *    SCOPES
     * ============================ */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeAllowsEvents($query)
    {
        return $query->where('allows_events', true);
    }

    public function scopeAllowsEducation($query)
    {
        return $query->where('allows_education', true);
    }

    public function scopeForEvents($query)
    {
        return $query->active()->allowsEvents();
    }

    public function scopeForEducation($query)
    {
        return $query->active()->allowsEducation();
    }

    public function scopePopular($query)
    {
        return $query->withCount('posts')->orderBy('posts_count', 'desc');
    }

    /* ============================
     *    MÉTODOS ESTÁTICOS
     * ============================ */

    public static function getEventTypes(): \Illuminate\Database\Eloquent\Collection
    {
        return self::forEvents()->get();
    }

    public static function getEducationalTypes(): \Illuminate\Database\Eloquent\Collection
    {
        return self::forEducation()->get();
    }

    public static function getAvailableTypes(): \Illuminate\Database\Eloquent\Collection
    {
        return self::active()->get();
    }

    public static function findByName(string $name): ?self
    {
        return self::where('name', $name)->active()->first();
    }

    /* ============================
     *    TIPOS PREDEFINIDOS
     * ============================ */

    public static function initializeDefaultTypes(): void
    {
        $defaultTypes = [
            [
                'name' => 'Artículo',
                'description' => 'Contenido informativo y educativo',
                'allows_events' => false,
                'allows_education' => true,
                'icon' => '📝',
                'is_active' => true,
            ],
            [
                'name' => 'Evento',
                'description' => 'Actividades y eventos culturales',
                'allows_events' => true,
                'allows_education' => false,
                'icon' => '🎭',
                'is_active' => true,
            ],
            [
                'name' => 'Galería',
                'description' => 'Colección de imágenes y multimedia',
                'allows_events' => false,
                'allows_education' => true,
                'icon' => '🖼️',
                'is_active' => true,
            ],
            [
                'name' => 'Noticia',
                'description' => 'Actualizaciones y novedades',
                'allows_events' => false,
                'allows_education' => false,
                'icon' => '📰',
                'is_active' => true,
            ],
            [
                'name' => 'Tutorial',
                'description' => 'Guías y tutoriales educativos',
                'allows_events' => false,
                'allows_education' => true,
                'icon' => '🎓',
                'is_active' => true,
            ],
        ];

        foreach ($defaultTypes as $type) {
            self::firstOrCreate(
                ['name' => $type['name']],
                $type
            );
        }
    }

    /* ============================
     *    HOOKS
     * ============================ */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($contentType) {
            if (is_null($contentType->allows_events)) {
                $contentType->allows_events = false;
            }
            if (is_null($contentType->allows_education)) {
                $contentType->allows_education = false;
            }
            if (is_null($contentType->is_active)) {
                $contentType->is_active = true;
            }
        });
    }
}