<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id', 
        'parent_id',
        'content',
        'like_count',
        'is_edited',
        'status'
    ];

    protected $casts = [
        'like_count' => 'integer',
        'is_edited' => 'boolean',
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

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    // RELACIÓN ELIMINADA - No existe en tu BD
    // public function reactions(): MorphMany

    /* ============================
     *    MÉTODOS ÚTILES
     * ============================ */

    public function isReply(): bool
    {
        return !is_null($this->parent_id);
    }

    public function isRoot(): bool
    {
        return is_null($this->parent_id);
    }

    public function isVisible(): bool
    {
        return $this->status === 'visible';
    }

    public function isHidden(): bool
    {
        return $this->status === 'hidden';
    }

    public function isReported(): bool
    {
        return $this->status === 'reported';
    }

    public function incrementLikeCount(): void
    {
        $this->increment('like_count');
    }

    public function decrementLikeCount(): void
    {
        if ($this->like_count > 0) {
            $this->decrement('like_count');
        }
    }

    public function markAsEdited(): void
    {
        $this->update([
            'is_edited' => true,
            'updated_at' => now()
        ]);
    }

    public function getNestedReplies($depth = 5)
    {
        if ($depth <= 0) {
            return collect();
        }

        return $this->replies()->with(['user', 'replies' => function($query) use ($depth) {
            $query->with(['user', 'replies' => function($q) use ($depth) {
                $q->withDepth($depth - 2);
            }]);
        }])->get();
    }

    /* ============================
     *    SCOPES
     * ============================ */

    public function scopeVisible($query)
    {
        return $query->where('status', 'visible');
    }

    public function scopeRootComments($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeReplies($query)
    {
        return $query->whereNotNull('parent_id');
    }

    public function scopeWithLikes($query, $minLikes = 1)
    {
        return $query->where('like_count', '>=', $minLikes);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopePopular($query)
    {
        return $query->orderBy('like_count', 'desc');
    }
}