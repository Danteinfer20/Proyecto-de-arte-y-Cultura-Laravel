<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'location_id',
        'organizer_id',
        'start_date',
        'end_date',
        'price',
        'max_capacity',
        'available_slots',
        'requires_rsvp',
        'event_type',
        'event_status'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'price' => 'decimal:2',
        'requires_rsvp' => 'boolean',
    ];

    /* ============================
     *    RELACIONES PRINCIPALES
     * ============================ */

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function performingArts(): HasMany
    {
        return $this->hasMany(PerformingArt::class);
    }

    public function attendance(): HasMany
    {
        return $this->hasMany(EventAttendance::class);
    }

    /* ============================
     *    SCOPES ÚTILES
     * ============================ */

    public function scopeUpcoming($query)
    {
        return $query->where('event_status', 'scheduled')
                    ->where('start_date', '>=', now());
    }

    public function scopeOngoing($query)
    {
        return $query->where('event_status', 'ongoing')
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
    }

    public function scopeFree($query)
    {
        return $query->where('event_type', 'free')
                    ->orWhere('price', 0);
    }

    public function scopeRequiresRsvp($query)
    {
        return $query->where('requires_rsvp', true);
    }

    /* ============================
     *    MÉTODOS ÚTILES
     * ============================ */

    public function isUpcoming(): bool
    {
        return $this->event_status === 'scheduled' && $this->start_date->isFuture();
    }

    public function isOngoing(): bool
    {
        return $this->event_status === 'ongoing' && 
               $this->start_date->isPast() && 
               $this->end_date->isFuture();
    }

    public function isFree(): bool
    {
        return $this->event_type === 'free' || $this->price == 0;
    }

    public function hasAvailableSlots(): bool
    {
        if ($this->max_capacity === null) {
            return true;
        }
        
        return $this->available_slots > 0;
    }

    public function getConfirmedAttendeesCount(): int
    {
        return $this->attendance()->where('status', 'confirmed')->count();
    }

    public function decreaseAvailableSlots(): void
    {
        if ($this->available_slots > 0) {
            $this->decrement('available_slots');
        }
    }

    public function increaseAvailableSlots(): void
    {
        if ($this->available_slots < $this->max_capacity) {
            $this->increment('available_slots');
        }
    }
}