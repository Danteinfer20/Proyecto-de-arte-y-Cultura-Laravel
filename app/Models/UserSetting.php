<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email_notifications',
        'push_notifications',
        'new_followers_notify',
        'comments_notify',
        'nearby_events_notify',
        'public_profile',
        'language',
        'theme'
    ];

    protected $casts = [
        'email_notifications' => 'boolean',
        'push_notifications' => 'boolean',
        'new_followers_notify' => 'boolean',
        'comments_notify' => 'boolean',
        'nearby_events_notify' => 'boolean',
        'public_profile' => 'boolean',
    ];

    /* ============================
     *    RELACIONES
     * ============================ */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /* ============================
     *    CONFIGURACIONES
     * ============================ */

    public static function getThemes(): array
    {
        return [
            'light' => '☀️ Claro',
            'dark' => '🌙 Oscuro',
            'auto' => '⚙️ Automático',
        ];
    }

    public static function getLanguages(): array
    {
        return [
            'es' => '🇪🇸 Español',
            'en' => '🇺🇸 English',
        ];
    }

    /* ============================
     *    MÉTODOS ÚTILES
     * ============================ */

    public function getThemeNameAttribute(): string
    {
        return self::getThemes()[$this->theme] ?? $this->theme;
    }

    public function getLanguageNameAttribute(): string
    {
        return self::getLanguages()[$this->language] ?? $this->language;
    }

    public function isEmailNotificationsEnabled(): bool
    {
        return $this->email_notifications;
    }

    public function isPushNotificationsEnabled(): bool
    {
        return $this->push_notifications;
    }

    public function isPublicProfile(): bool
    {
        return $this->public_profile;
    }

    public function enableAllNotifications(): void
    {
        $this->update([
            'email_notifications' => true,
            'push_notifications' => true,
            'new_followers_notify' => true,
            'comments_notify' => true,
            'nearby_events_notify' => true,
        ]);
    }

    public function disableAllNotifications(): void
    {
        $this->update([
            'email_notifications' => false,
            'push_notifications' => false,
            'new_followers_notify' => false,
            'comments_notify' => false,
            'nearby_events_notify' => false,
        ]);
    }

    public function toggleEmailNotifications(): bool
    {
        return $this->update([
            'email_notifications' => !$this->email_notifications
        ]);
    }

    public function togglePushNotifications(): bool
    {
        return $this->update([
            'push_notifications' => !$this->push_notifications
        ]);
    }

    public function togglePublicProfile(): bool
    {
        return $this->update([
            'public_profile' => !$this->public_profile
        ]);
    }

    /* ============================
     *    SCOPES
     * ============================ */

    public function scopeWithEmailNotifications($query)
    {
        return $query->where('email_notifications', true);
    }

    public function scopeWithPushNotifications($query)
    {
        return $query->where('push_notifications', true);
    }

    public function scopePublicProfiles($query)
    {
        return $query->where('public_profile', true);
    }

    public function scopeByLanguage($query, string $language)
    {
        return $query->where('language', $language);
    }

    public function scopeByTheme($query, string $theme)
    {
        return $query->where('theme', $theme);
    }

    /* ============================
     *    HOOKS
     * ============================ */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($setting) {
            // Valores por defecto si no se especifican
            if (is_null($setting->email_notifications)) {
                $setting->email_notifications = true;
            }
            if (is_null($setting->push_notifications)) {
                $setting->push_notifications = true;
            }
            if (is_null($setting->public_profile)) {
                $setting->public_profile = true;
            }
            if (empty($setting->language)) {
                $setting->language = 'es';
            }
            if (empty($setting->theme)) {
                $setting->theme = 'light';
            }
        });
    }
}