<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'ip_address',
        'user_agent',
        'related_id',
        'related_type'
    ];

    // RELACIÓN AGREGADA
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}