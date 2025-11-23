<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventAttendance extends Model
{
    use HasFactory;

    // AGREGAR ESTA LÍNEA
    protected $table = 'event_attendance';

    protected $fillable = [
        'event_id',
        'user_id',
        'status',
        'guest_count',
        'qr_code',
        'checked_in',
        'checked_in_at'
    ];

    protected $casts = [
        'guest_count' => 'integer',
        'checked_in' => 'boolean',
        'checked_in_at' => 'datetime',
    ];

    // ... el resto del código permanece igual
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}