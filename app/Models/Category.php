<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'icon',
        'color',
        'slug',
        'category_type',
        'is_active',
        'sort_order',
        'parent_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /* ============================
     *    RELACIONES
     * ============================ */

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    // NUEVA RELACIÓN: Eventos a través de posts
    public function events(): HasManyThrough
    {
        return $this->hasManyThrough(Event::class, Post::class);
    }

    /* ============================
     *    MÉTODOS ÚTILES
     * ============================ */

    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }

    public function getFullPathAttribute(): string
    {
        $path = [];
        $category = $this;

        while ($category) {
            $path[] = $category->name;
            $category = $category->parent;
        }

        return implode(' > ', array_reverse($path));
    }

    public function getTotalPostsCountAttribute(): int
    {
        $categoryIds = $this->getAllDescendantIds();
        $categoryIds[] = $this->id;

        return Post::whereIn('category_id', $categoryIds)->count();
    }

    public function getAllDescendantIds(): array
    {
        $ids = [];

        foreach ($this->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $child->getAllDescendantIds());
        }

        return $ids;
    }

    public function isEducational(): bool
    {
        return $this->category_type === 'education';
    }

    public function isArt(): bool
    {
        return $this->category_type === 'art';
    }

    public function isEvent(): bool
    {
        return $this->category_type === 'event';
    }

    public function isProduct(): bool
    {
        return $this->category_type === 'product';
    }

    /* ============================
     *    SCOPES
     * ============================ */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeWithChildren($query)
    {
        return $query->with('children');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('category_type', $type);
    }

    public function scopeEducational($query)
    {
        return $this->scopeByType($query, 'education');
    }

    public function scopeArt($query)
    {
        return $this->scopeByType($query, 'art');
    }

    public function scopeEvent($query)
    {
        return $this->scopeByType($query, 'event');
    }

    public function scopeProduct($query)
    {
        return $this->scopeByType($query, 'product');
    }
}