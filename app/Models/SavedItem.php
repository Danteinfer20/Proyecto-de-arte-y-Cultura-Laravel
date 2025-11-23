<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavedItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'category'
    ];

    /* ============================
     *    RELACIONES
     * ============================ */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /* ============================
     *    CATEGORÍAS DE GUARDADO
     * ============================ */

    public static function getCategories(): array
    {
        return [
            'read_later' => '📖 Leer después',
            'favorites' => '⭐ Favoritos',
            'inspiration' => '💡 Inspiración',
            'educational' => '🎓 Educativo',
        ];
    }

    /* ============================
     *    MÉTODOS ÚTILES
     * ============================ */

    public function isReadLater(): bool
    {
        return $this->category === 'read_later';
    }

    public function isFavorite(): bool
    {
        return $this->category === 'favorites';
    }

    public function isInspiration(): bool
    {
        return $this->category === 'inspiration';
    }

    public function isEducational(): bool
    {
        return $this->category === 'educational';
    }

    public function getCategoryNameAttribute(): string
    {
        return self::getCategories()[$this->category] ?? $this->category;
    }

    public function getCategoryIconAttribute(): string
    {
        return [
            'read_later' => '📖',
            'favorites' => '⭐',
            'inspiration' => '💡',
            'educational' => '🎓',
        ][$this->category] ?? '📌';
    }

    /* ============================
     *    SCOPES
     * ============================ */

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeReadLater($query)
    {
        return $this->scopeByCategory($query, 'read_later');
    }

    public function scopeFavorites($query)
    {
        return $this->scopeByCategory($query, 'favorites');
    }

    public function scopeInspiration($query)
    {
        return $this->scopeByCategory($query, 'inspiration');
    }

    public function scopeEducational($query)
    {
        return $this->scopeByCategory($query, 'educational');
    }

    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForPost($query, int $postId)
    {
        return $query->where('post_id', $postId);
    }

    /* ============================
     *    MÉTODOS DE GESTIÓN
     * ============================ */

    public function markAsReadLater(): void
    {
        $this->update(['category' => 'read_later']);
    }

    public function markAsFavorite(): void
    {
        $this->update(['category' => 'favorites']);
    }

    public function markAsInspiration(): void
    {
        $this->update(['category' => 'inspiration']);
    }

    public function markAsEducational(): void
    {
        $this->update(['category' => 'educational']);
    }

    public function changeCategory(string $category): bool
    {
        if (array_key_exists($category, self::getCategories())) {
            return $this->update(['category' => $category]);
        }

        return false;
    }
}