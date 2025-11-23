<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'neighborhood',
        'city',
        'latitude',
        'longitude',
        'location_type',
        'phone',
        'opening_hours',
        'description',
        'photo',
        'website',
        'capacity',
        'is_accessible',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'capacity' => 'integer',
        'is_accessible' => 'boolean',
    ];

    /* ============================
     *    RELACIONES
     * ============================ */

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /* ============================
     *    MÉTODOS ÚTILES
     * ============================ */

    public function getCoordinatesAttribute(): array
    {
        return [
            'lat' => (float) $this->latitude,
            'lng' => (float) $this->longitude,
        ];
    }

    public function hasCoordinates(): bool
    {
        return !is_null($this->latitude) && !is_null($this->longitude);
    }

    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->address,
            $this->neighborhood,
            $this->city,
        ]);

        return implode(', ', $parts);
    }

    public function isInPopayan(): bool
    {
        return $this->city === 'Popayán';
    }

    public function isAccessible(): bool
    {
        return $this->is_accessible;
    }

    public function hasCapacityInfo(): bool
    {
        return !is_null($this->capacity);
    }

    public function getLocationTypeNameAttribute(): string
    {
        return self::getLocationTypes()[$this->location_type] ?? $this->location_type;
    }

    /* ============================
     *    SCOPES
     * ============================ */

    public function scopeInPopayan($query)
    {
        return $query->where('city', 'Popayán');
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('location_type', $type);
    }

    public function scopeAccessible($query)
    {
        return $query->where('is_accessible', true);
    }

    public function scopeWithCapacity($query, int $minCapacity = 1)
    {
        return $query->where('capacity', '>=', $minCapacity);
    }

    public function scopeNearby($query, float $latitude, float $longitude, int $radiusKm = 10)
    {
        return $query
            ->select('*')
            ->selectRaw(
                '(6371 * acos(
                    cos(radians(?)) * cos(radians(latitude)) *
                    cos(radians(longitude) - radians(?)) +
                    sin(radians(?)) * sin(radians(latitude))
                )) AS distance',
                [$latitude, $longitude, $latitude]
            )
            ->having('distance', '<', $radiusKm)
            ->orderBy('distance');
    }

    /* ============================
     *    TIPOS DE UBICACIONES
     * ============================ */

    public static function getLocationTypes(): array
    {
        return [
            'museum' => 'Museo',
            'theater' => 'Teatro',
            'gallery' => 'Galería',
            'street' => 'Calle',
            'park' => 'Parque',
            'cultural_center' => 'Centro Cultural',
            'auditorium' => 'Auditorio',
            'library' => 'Biblioteca',
            'educational_center' => 'Centro Educativo',
        ];
    }

    public static function getCulturalLocationTypes(): array
    {
        return [
            'museum', 'theater', 'gallery', 'cultural_center', 'auditorium'
        ];
    }

    public function isCulturalLocation(): bool
    {
        return in_array($this->location_type, self::getCulturalLocationTypes());
    }

    public function isOutdoor(): bool
    {
        return in_array($this->location_type, ['street', 'park']);
    }

    public function isIndoor(): bool
    {
        return !$this->isOutdoor();
    }
}