<?php
// app/Models/Post.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id', 
        'content_type_id',
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'status',
        'is_featured',
        'is_educational', // Agregado para consistencia
        'allow_comments',
        'view_count',
        'share_count',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_educational' => 'boolean',
        'allow_comments' => 'boolean',
    ];

    /* ============================
     *    RELACIONES
     * ============================ */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function contentType()
    {
        return $this->belongsTo(ContentType::class);
    }

    // 🔥 RELACIÓN AGREGADA - Esto soluciona el error
    public function media()
    {
        return $this->hasMany(PostMedia::class);
    }

    public function event()
    {
        return $this->hasOne(Event::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }

    public function savedItems()
    {
        return $this->hasMany(SavedItem::class);
    }

    /* ============================
     *    SCOPES
     * ============================ */

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeEducational($query)
    {
        return $query->where('is_educational', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /* ============================
     *    MÉTODOS ÚTILES
     * ============================ */

    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    public function incrementShareCount()
    {
        $this->increment('share_count');
    }

    // 🔧 MÉTODO CORREGIDO - Evita recursión infinita
    public function getExcerptAttribute(): string
    {
        // Si ya existe un excerpt definido, úsalo
        if (!empty($this->attributes['excerpt'])) {
            return $this->attributes['excerpt'];
        }

        // Si no hay excerpt, genera uno del contenido
        return Str::limit(strip_tags($this->attributes['content'] ?? ''), 150);
    }

    // Método alternativo más seguro
    public function getSafeExcerptAttribute(): string
    {
        $excerpt = $this->attributes['excerpt'] ?? null;
        
        if (!empty($excerpt)) {
            return $excerpt;
        }

        $content = $this->attributes['content'] ?? '';
        return Str::limit(strip_tags($content), 150);
    }

    public function isPublished(): bool
    {
        return $this->status === 'published' && $this->published_at !== null;
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isArchived(): bool
    {
        return $this->status === 'archived';
    }

    // Helper para obtener la URL del post
    public function getUrlAttribute(): string
    {
        return route('posts.show', $this->slug ?? $this->id);
    }

    // Método para obtener imagen destacada
    public function getFeaturedImageUrlAttribute(): ?string
    {
        if ($this->featured_image) {
            return Storage::url($this->featured_image);
        }
        return null;
    }

    // Obtener imagen principal desde media
    public function getMainImageAttribute(): ?string
    {
        $coverImage = $this->media->where('is_cover', true)->first();
        if ($coverImage) {
            return $coverImage->file_url;
        }

        $firstImage = $this->media->where('file_type', 'image')->first();
        return $firstImage ? $firstImage->file_url : null;
    }

    // Método para publicar el post
    public function publish(): bool
    {
        return $this->update([
            'status' => 'published',
            'published_at' => now()
        ]);
    }

    // Método para archivar el post
    public function archive(): bool
    {
        return $this->update([
            'status' => 'archived'
        ]);
    }

    // Método para marcar como destacado
    public function markAsFeatured(): bool
    {
        return $this->update([
            'is_featured' => true
        ]);
    }

    // Método para quitar de destacados
    public function unmarkAsFeatured(): bool
    {
        return $this->update([
            'is_featured' => false
        ]);
    }

    /* ============================
     *    HOOKS
     * ============================ */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            // Generar slug automáticamente si no existe
            if (empty($post->slug) && !empty($post->title)) {
                $post->slug = Str::slug($post->title);
            }

            // Generar excerpt automáticamente si no existe
            if (empty($post->excerpt) && !empty($post->content)) {
                $post->excerpt = Str::limit(strip_tags($post->content), 150);
            }

            // Establecer valores por defecto
            if (is_null($post->status)) {
                $post->status = 'draft';
            }
            if (is_null($post->view_count)) {
                $post->view_count = 0;
            }
            if (is_null($post->share_count)) {
                $post->share_count = 0;
            }
            if (is_null($post->allow_comments)) {
                $post->allow_comments = true;
            }
        });

        static::updating(function ($post) {
            // Regenerar slug si el título cambió
            if ($post->isDirty('title') && empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }
}