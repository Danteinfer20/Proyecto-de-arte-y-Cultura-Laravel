<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\PasswordResetToken
 *
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordResetToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordResetToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordResetToken query()
 * @mixin \Eloquent
 */
class PasswordResetToken extends Model
{
    use HasFactory;

    // Nombre de la tabla (Laravel ya no usa "password_resets")
    protected $table = 'password_reset_tokens';

    // No usa timestamps (created_at / updated_at)
    public $timestamps = false;

    // Primary key personalizada
    protected $primaryKey = 'email';

    // La PK NO es incremental
    public $incrementing = false;

    // El tipo de la PK
    protected $keyType = 'string';

    // Permitimos asignación masiva
    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];

    // Cast
    protected $casts = [
        'created_at' => 'datetime',
    ];

    // 🔗 RELACIÓN: cada token pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    // Verificar si un token expiró (por ejemplo, 60 minutos)
    public function isExpired()
    {
        return $this->created_at->diffInMinutes(now()) > 60;
    }
}
