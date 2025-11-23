<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiRecommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'recommended_post_id',
        'recommendation_type',
        'confidence_score',
        'reason'
    ];

    protected $casts = [
        'confidence_score' => 'decimal:2',
    ];

    /* ============================
     *    RELACIONES
     * ============================ */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function recommendedPost(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'recommended_post_id');
    }

    /* ============================
     *    TIPOS DE RECOMENDACIONES
     * ============================ */

    public static function getRecommendationTypes(): array
    {
        return [
            'cultural' => '🏛️ Cultural',
            'educational' => '🎓 Educativo',
            'event' => '🎭 Evento',
            'product' => '🛍️ Producto',
        ];
    }

    /* ============================
     *    MÉTODOS ÚTILES
     * ============================ */

    public function getRecommendationTypeNameAttribute(): string
    {
        return self::getRecommendationTypes()[$this->recommendation_type] ?? $this->recommendation_type;
    }

    public function isCultural(): bool
    {
        return $this->recommendation_type === 'cultural';
    }

    public function isEducational(): bool
    {
        return $this->recommendation_type === 'educational';
    }

    public function isEvent(): bool
    {
        return $this->recommendation_type === 'event';
    }

    public function isProduct(): bool
    {
        return $this->recommendation_type === 'product';
    }

    public function hasHighConfidence(): bool
    {
        return $this->confidence_score >= 0.8;
    }

    public function hasMediumConfidence(): bool
    {
        return $this->confidence_score >= 0.5 && $this->confidence_score < 0.8;
    }

    public function hasLowConfidence(): bool
    {
        return $this->confidence_score < 0.5;
    }

    public function getConfidencePercentageAttribute(): int
    {
        return (int) round($this->confidence_score * 100);
    }

    public function getConfidenceLevelAttribute(): string
    {
        if ($this->hasHighConfidence()) {
            return 'high';
        } elseif ($this->hasMediumConfidence()) {
            return 'medium';
        } else {
            return 'low';
        }
    }

    public function getConfidenceLabelAttribute(): string
    {
        return [
            'high' => '🟢 Alta confianza',
            'medium' => '🟡 Media confianza',
            'low' => '🔴 Baja confianza',
        ][$this->getConfidenceLevelAttribute()] ?? '⚪ Desconocida';
    }

    public function hasReason(): bool
    {
        return !empty($this->reason);
    }

    public function getTruncatedReasonAttribute(): string
    {
        if (!$this->hasReason()) {
            return 'Sin razón especificada';
        }

        return strlen($this->reason) > 100 
            ? substr($this->reason, 0, 100) . '...' 
            : $this->reason;
    }

    /* ============================
     *    MÉTODOS DE PERSONALIZACIÓN
     * ============================ */

    public function getPersonalizedMessageAttribute(): string
    {
        $baseMessages = [
            'cultural' => "Basado en tu interés en la cultura de Popayán, te recomendamos este contenido.",
            'educational' => "Para expandir tu conocimiento sobre Popayán, te sugerimos este material educativo.",
            'event' => "¡No te pierdas este evento en Popayán! Podría interesarte.",
            'product' => "Descubre esta artesanía única de Popayán que se alinea con tus gustos.",
        ];

        $baseMessage = $baseMessages[$this->recommendation_type] ?? "Te recomendamos este contenido de Popayán.";

        if ($this->hasReason()) {
            return $baseMessage . " " . $this->reason;
        }

        return $baseMessage . " Nuestra IA está " . $this->confidence_percentage . "% segura de que te gustará.";
    }

    /* ============================
     *    SCOPES
     * ============================ */

    public function scopeByType($query, string $type)
    {
        return $query->where('recommendation_type', $type);
    }

    public function scopeCultural($query)
    {
        return $this->scopeByType($query, 'cultural');
    }

    public function scopeEducational($query)
    {
        return $this->scopeByType($query, 'educational');
    }

    public function scopeEvents($query)
    {
        return $this->scopeByType($query, 'event');
    }

    public function scopeProducts($query)
    {
        return $this->scopeByType($query, 'product');
    }

    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeHighConfidence($query)
    {
        return $query->where('confidence_score', '>=', 0.8);
    }

    public function scopeMediumConfidence($query)
    {
        return $query->where('confidence_score', '>=', 0.5)
                    ->where('confidence_score', '<', 0.8);
    }

    public function scopeWithReason($query)
    {
        return $query->whereNotNull('reason')
                    ->where('reason', '!=', '');
    }

    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /* ============================
     *    MÉTODOS DE GENERACIÓN
     * ============================ */

    public static function generateForUser(User $user, string $type, Post $post, float $confidence, string $reason = ''): self
    {
        return self::create([
            'user_id' => $user->id,
            'recommended_post_id' => $post->id,
            'recommendation_type' => $type,
            'confidence_score' => $confidence,
            'reason' => $reason,
        ]);
    }

    public function updateConfidence(float $newScore): bool
    {
        return $this->update(['confidence_score' => $newScore]);
    }

    public function addReason(string $additionalReason): bool
    {
        $currentReason = $this->reason ?? '';
        $newReason = $currentReason ? $currentReason . ' ' . $additionalReason : $additionalReason;
        
        return $this->update(['reason' => $newReason]);
    }

    /* ============================
     *    VALIDACIÓN
     * ============================ */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($recommendation) {
            // Validar que el score esté entre 0 y 1
            if ($recommendation->confidence_score < 0 || $recommendation->confidence_score > 1) {
                throw new \InvalidArgumentException("El score de confianza debe estar entre 0 y 1.");
            }

            // Validar tipo de recomendación
            $validTypes = array_keys(self::getRecommendationTypes());
            if (!in_array($recommendation->recommendation_type, $validTypes)) {
                throw new \InvalidArgumentException("Tipo de recomendación no válido: {$recommendation->recommendation_type}");
            }
        });
    }
}