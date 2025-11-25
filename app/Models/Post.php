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
        'excerpt', // Asegúrate que esté en fillable
        'featured_image',
        'status',
        'is_featured',
        'allow_comments',
        'view_count',
        'share_count',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
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

    /* ============================
     *    MÉTODOS ÚTILES
     * ============================ */

    public function incrementViewCount()
    {
        $this->increment('view_count');
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
}