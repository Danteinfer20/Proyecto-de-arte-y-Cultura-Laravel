<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'reaction_type',
    ];

    /* ============================
     *    RELACIONES
     * ============================ */

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /* ============================
     *    TIPOS DE REACCIONES
     * ============================ */

    public static function getReactionTypes(): array
    {
        return [
            'like' => '👍 Me gusta',
            'love' => '❤️ Me encanta', 
            'inspire' => '💡 Inspira',
            'interest' => '🔍 Interesa',
        ];
    }

    public static function getReactionIcons(): array
    {
        return [
            'like' => '👍',
            'love' => '❤️',
            'inspire' => '💡', 
            'interest' => '🔍',
        ];
    }

    public static function isValidType(string $type): bool
    {
        return array_key_exists($type, self::getReactionTypes());
    }

    /* ============================
     *    SCOPES
     * ============================ */

    public function scopeOfType($query, string $type)
    {
        return $query->where('reaction_type', $type);
    }

    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForPost($query, int $postId)
    {
        return $query->where('post_id', $postId);
    }

    public function scopeLikes($query)
    {
        return $this->scopeOfType($query, 'like');
    }

    public function scopeLoves($query)
    {
        return $this->scopeOfType($query, 'love');
    }

    public function scopeInspires($query)
    {
        return $this->scopeOfType($query, 'inspire');
    }

    public function scopeInterests($query)
    {
        return $this->scopeOfType($query, 'interest');
    }

    /* ============================
     *    MÉTODOS ÚTILES
     * ============================ */

    public function isType(string $type): bool
    {
        return $this->reaction_type === $type;
    }

    public function isLike(): bool
    {
        return $this->isType('like');
    }

    public function isLove(): bool
    {
        return $this->isType('love');
    }

    public function isInspire(): bool
    {
        return $this->isType('inspire');
    }

    public function isInterest(): bool
    {
        return $this->isType('interest');
    }

    public function getTypeNameAttribute(): string
    {
        return self::getReactionTypes()[$this->reaction_type] ?? $this->reaction_type;
    }

    public function getIconAttribute(): string
    {
        return self::getReactionIcons()[$this->reaction_type] ?? '❓';
    }

    public function getEmojiAttribute(): string
    {
        return $this->getIconAttribute();
    }

    /* ============================
     *    VALIDACIÓN
     * ============================ */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($reaction) {
            if (!self::isValidType($reaction->reaction_type)) {
                throw new \InvalidArgumentException("Tipo de reacción no válido: {$reaction->reaction_type}");
            }
        });
    }
}