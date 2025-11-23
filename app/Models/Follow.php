<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Follow
 *
 * @property int $id
 * @property int $follower_id
 * @property int $followed_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $follower
 * @property-read \App\Models\User|null $following
 * @method static \Illuminate\Database\Eloquent\Builder|Follow followers($userId)
 * @method static \Illuminate\Database\Eloquent\Builder|Follow following($userId)
 * @method static \Illuminate\Database\Eloquent\Builder|Follow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Follow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Follow query()
 * @method static \Illuminate\Database\Eloquent\Builder|Follow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Follow whereFollowedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Follow whereFollowerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Follow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Follow whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Follow extends Model
{
    use HasFactory;

    protected $fillable = [
        'follower_id',
        'following_id',
        'notifications_enabled'
    ];

    protected $casts = [
        'notifications_enabled' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    // Usuario que sigue
    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    // Usuario que es seguido
    public function following()
    {
        return $this->belongsTo(User::class, 'following_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    // Obtener seguidores de un usuario
    public function scopeFollowers($query, $userId)
    {
        return $query->where('following_id', $userId);
    }

    // Obtener usuarios a los que sigue un usuario
    public function scopeFollowing($query, $userId)
    {
        return $query->where('follower_id', $userId);
    }

    /*
    |--------------------------------------------------------------------------
    | MÉTODOS ÚTILES
    |--------------------------------------------------------------------------
    */

    // Verifica si el follow es mutuo
    public function isMutual()
    {
        return self::where('follower_id', $this->following_id)
                    ->where('following_id', $this->follower_id)
                    ->exists();
    }

    // Alternar notificaciones
    public function toggleNotifications()
    {
        $this->notifications_enabled = ! $this->notifications_enabled;
        $this->save();
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDACIÓN INTERNA
    |--------------------------------------------------------------------------
    */

    // Prevenir que un usuario se siga a sí mismo
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($follow) {
            if ($follow->follower_id === $follow->following_id) {
                throw new \Exception("A user cannot follow themselves.");
            }
        });
    }
}
