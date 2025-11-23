<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'excerpt',
        'content',
        'featured_image',
        'status',
        'is_featured',
        'is_educational',
        'view_count',
        'share_count',
        'allow_comments',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_educational' => 'boolean',
        'allow_comments' => 'boolean',
        'view_count' => 'integer',
        'share_count' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function contentType(): BelongsTo
    {
        return $this->belongsTo(ContentType::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(PostMedia::class);
    }

    // RELACIÓN CORREGIDA - No es polimórfica
    public function reactions(): HasMany
    {
        return $this->hasMany(Reaction::class);
    }

    // RELACIÓN CORREGIDA - No es polimórfica en tu BD
    public function savedItems(): HasMany
    {
        return $this->hasMany(SavedItem::class);
    }

    public function events(): HasOne
    {
        return $this->hasOne(Event::class);
    }

    public function educationalContent(): HasOne
    {
        return $this->hasOne(EducationalContent::class);
    }

    /* ============================
     *    SCOPES ÚTILES
     * ============================ */

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at');
    }

    public function scopeEducational($query)
    {
        return $query->where('is_educational', true);
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

    public function getExcerptAttribute(): string
    {
        if ($this->excerpt) {
            return $this->excerpt;
        }

        return Str::limit(strip_tags($this->content), 150);
    }

    public function isPublished(): bool
    {
        return $this->status === 'published' && $this->published_at !== null;
    }
}