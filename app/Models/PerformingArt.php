<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerformingArt extends Model
{
    use HasFactory;

    // CORRECCIÓN: Nombre de tabla
    protected $table = 'performing_arts';

    protected $fillable = [
        'event_id',
        'art_type',
        'duration_minutes',
        'artistic_director',
        'company',
        'genre',
        'target_audience',
        'technical_requirements',
        'cast_members'
    ];

    protected $casts = [
        'duration_minutes' => 'integer',
        'cast_members' => 'array',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public static function getArtTypes(): array
    {
        return [
            'circus' => '🎪 Circo',
            'theater' => '🎭 Teatro',
            'dance' => '💃 Danza',
            'performance' => '🎨 Performance',
            'magic' => '🔮 Magia',
            'music' => '🎵 Música',
            'storytelling' => '📖 Narración Oral',
        ];
    }

    public static function getTargetAudiences(): array
    {
        return [
            'all' => '👨‍👩‍👧‍👦 Todo público',
            'children' => '🧒 Infantil',
            'youth' => '👦 Juvenil',
            'adults' => '👨‍💼 Adultos',
            'family' => '👪 Familiar',
        ];
    }

    public function getArtTypeNameAttribute(): string
    {
        return self::getArtTypes()[$this->art_type] ?? $this->art_type;
    }

    public function getTargetAudienceNameAttribute(): string
    {
        return self::getTargetAudiences()[$this->target_audience] ?? $this->target_audience;
    }

    public function getDurationFormattedAttribute(): string
    {
        if ($this->duration_minutes < 60) {
            return $this->duration_minutes . ' min';
        }

        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;

        if ($minutes === 0) {
            return $hours . ' h';
        }

        return $hours . ' h ' . $minutes . ' min';
    }

    public function hasCastMembers(): bool
    {
        return !empty($this->cast_members) && is_array($this->cast_members);
    }

    public function getCastCount(): int
    {
        if (!$this->hasCastMembers()) {
            return 0;
        }

        return count($this->cast_members);
    }

    public function hasTechnicalRequirements(): bool
    {
        return !empty($this->technical_requirements);
    }

    public function hasCompany(): bool
    {
        return !empty($this->company);
    }

    public function hasArtisticDirector(): bool
    {
        return !empty($this->artistic_director);
    }

    public function isShortPerformance(): bool
    {
        return $this->duration_minutes <= 30;
    }

    public function isLongPerformance(): bool
    {
        return $this->duration_minutes > 90;
    }

    public function isMediumPerformance(): bool
    {
        return $this->duration_minutes > 30 && $this->duration_minutes <= 90;
    }

    public function addCastMember(string $name, string $role = ''): void
    {
        $cast = $this->cast_members ?? [];
        $cast[] = [
            'name' => $name,
            'role' => $role,
            'id' => uniqid()
        ];
        
        $this->update(['cast_members' => $cast]);
    }

    public function removeCastMember(string $id): void
    {
        $cast = $this->cast_members ?? [];
        $cast = array_filter($cast, function($member) use ($id) {
            return ($member['id'] ?? '') !== $id;
        });
        
        $this->update(['cast_members' => array_values($cast)]);
    }

    public function getCastMembersByRole(string $role): array
    {
        if (!$this->hasCastMembers()) {
            return [];
        }

        return array_filter($this->cast_members, function($member) use ($role) {
            return ($member['role'] ?? '') === $role;
        });
    }

    public function scopeByArtType($query, string $type)
    {
        return $query->where('art_type', $type);
    }

    public function scopeTheater($query)
    {
        return $this->scopeByArtType($query, 'theater');
    }

    public function scopeDance($query)
    {
        return $this->scopeByArtType($query, 'dance');
    }

    public function scopeMusic($query)
    {
        return $this->scopeByArtType($query, 'music');
    }

    public function scopeCircus($query)
    {
        return $this->scopeByArtType($query, 'circus');
    }

    public function scopeShortPerformances($query)
    {
        return $query->where('duration_minutes', '<=', 30);
    }

    public function scopeLongPerformances($query)
    {
        return $query->where('duration_minutes', '>', 90);
    }

    public function scopeWithTechnicalRequirements($query)
    {
        return $query->whereNotNull('technical_requirements')
                    ->where('technical_requirements', '!=', '');
    }

    public function scopeForTargetAudience($query, string $audience)
    {
        return $query->where('target_audience', $audience);
    }
}