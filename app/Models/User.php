<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'user_type',
        'birth_date',
        'gender',
        'phone',
        'city',
        'neighborhood',
        'bio',
        'profile_picture',
        'cover_picture',
        'website',
        'social_media',
        'email_verified_at', // CORRECCIÓN: Campo agregado
        'last_login_at',
        'status',
        'is_verified',
        'is_active',
        'remember_token' // CORRECCIÓN: Campo agregado
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'birth_date' => 'date',
        'social_media' => 'array',
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
    ];

    /* ============================
     *    RELACIONES PRINCIPALES
     * ============================ */

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(Reaction::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function savedItems(): HasMany
    {
        return $this->hasMany(SavedItem::class);
    }

    public function performingArts(): HasMany
    {
        return $this->hasMany(PerformingArt::class);
    }

    public function eventAttendance(): HasMany
    {
        return $this->hasMany(EventAttendance::class);
    }

    public function userSettings(): HasOne
    {
        return $this->hasOne(UserSetting::class);
    }

    public function userStatistics(): HasOne
    {
        return $this->hasOne(UserStatistic::class);
    }

    /* ============================
     *    SCOPES ÚTILES
     * ============================ */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeArtists($query)
    {
        return $query->where('user_type', 'artist');
    }

    public function scopeCulturalManagers($query)
    {
        return $query->where('user_type', 'cultural_manager');
    }

    public function scopeVisitors($query)
    {
        return $query->where('user_type', 'visitor');
    }

    /* ============================
     *    ROLES Y PERMISOS (CORREGIDOS)
     * ============================ */

    public function isArtist(): bool { return $this->user_type === 'artist'; }
    public function isCulturalManager(): bool { return $this->user_type === 'cultural_manager'; }
    public function isVisitor(): bool { return $this->user_type === 'visitor'; }
    public function isAdmin(): bool { return $this->user_type === 'admin'; }

    public function isActive(): bool
    {
        return $this->status === 'active' && $this->is_active;
    }

    /* ============================
     *    ACCESSORS PERSONALIZADOS
     * ============================ */

    public function getAvatarUrlAttribute(): string
    {
        if ($this->profile_picture) {
            return asset('storage/' . $this->profile_picture);
        }

        return match ($this->user_type) {
            'artist' => asset('images/default-avatar-artist.png'),
            'cultural_manager' => asset('images/default-avatar-organizer.png'),
            default => asset('images/default-avatar.png'),
        };
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->username ? '@' . $this->username : $this->name;
    }

    public function getUserTypeFormattedAttribute(): string
    {
        return match ($this->user_type) {
            'artist' => '🎨 Artista',
            'cultural_manager' => '🎭 Gestor Cultural',
            'visitor' => '👥 Visitante',
            'admin' => '👑 Administrador',
            default => 'Usuario',
        };
    }

    public function getAgeAttribute(): ?int
    {
        return $this->birth_date?->age;
    }

    public function isEmailVerified(): bool
    {
        return !is_null($this->email_verified_at);
    }

    public function markEmailAsVerified(): bool
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }
}