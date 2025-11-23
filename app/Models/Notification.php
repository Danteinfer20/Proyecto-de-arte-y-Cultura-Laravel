<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'action_url',
        'is_read',
        'read_at'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /* ============================
     *    RELACIONES
     * ============================ */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /* ============================
     *    TIPOS DE NOTIFICACIONES
     * ============================ */

    public static function getNotificationTypes(): array
    {
        return [
            'new_follower' => '👥 Nuevo seguidor',
            'comment' => '💬 Nuevo comentario',
            'reaction' => '❤️ Nueva reacción',
            'event_reminder' => '⏰ Recordatorio de evento',
            'message' => '✉️ Nuevo mensaje',
            'sale' => '💰 Nueva venta',
            'system' => '⚙️ Sistema',
            'educational' => '🎓 Contenido educativo',
        ];
    }

    /* ============================
     *    MÉTODOS ÚTILES
     * ============================ */

    public function getTypeNameAttribute(): string
    {
        return self::getNotificationTypes()[$this->type] ?? $this->type;
    }

    public function isRead(): bool
    {
        return $this->is_read;
    }

    public function isUnread(): bool
    {
        return !$this->is_read;
    }

    public function hasAction(): bool
    {
        return !empty($this->action_url);
    }

    public function markAsRead(): bool
    {
        if (!$this->is_read) {
            return $this->update([
                'is_read' => true,
                'read_at' => now()
            ]);
        }
        return false;
    }

    public function markAsUnread(): bool
    {
        if ($this->is_read) {
            return $this->update([
                'is_read' => false,
                'read_at' => null
            ]);
        }
        return false;
    }

    public function getExcerptAttribute(): string
    {
        return strlen($this->message) > 100 
            ? substr($this->message, 0, 100) . '...' 
            : $this->message;
    }

    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    public function getIconAttribute(): string
    {
        $icons = [
            'new_follower' => '👥',
            'comment' => '💬',
            'reaction' => '❤️',
            'event_reminder' => '⏰',
            'message' => '✉️',
            'sale' => '💰',
            'system' => '⚙️',
            'educational' => '🎓',
        ];

        return $icons[$this->type] ?? '🔔';
    }

    /* ============================
     *    SCOPES
     * ============================ */

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeRecent($query, int $hours = 24)
    {
        return $query->where('created_at', '>=', now()->subHours($hours));
    }

    public function scopeWithAction($query)
    {
        return $query->whereNotNull('action_url')
                    ->where('action_url', '!=', '');
    }

    public function scopeFollowers($query)
    {
        return $this->scopeByType($query, 'new_follower');
    }

    public function scopeComments($query)
    {
        return $this->scopeByType($query, 'comment');
    }

    public function scopeReactions($query)
    {
        return $this->scopeByType($query, 'reaction');
    }

    public function scopeEvents($query)
    {
        return $this->scopeByType($query, 'event_reminder');
    }

    /* ============================
     *    MÉTODOS DE CREACIÓN
     * ============================ */

    public static function createForUser(User $user, string $type, string $title, string $message, string $actionUrl = ''): self
    {
        return self::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'action_url' => $actionUrl,
            'is_read' => false,
        ]);
    }

    public static function notifyNewFollower(User $user, User $follower): self
    {
        return self::createForUser(
            $user,
            'new_follower',
            'Nuevo seguidor',
            "{$follower->name} empezó a seguirte",
            "/users/{$follower->username}"
        );
    }

    public static function notifyNewComment(User $user, Comment $comment): self
    {
        return self::createForUser(
            $user,
            'comment',
            'Nuevo comentario',
            "{$comment->user->name} comentó en tu publicación",
            "/posts/{$comment->post->slug}#comment-{$comment->id}"
        );
    }

    public static function notifyEventReminder(User $user, Event $event): self
    {
        return self::createForUser(
            $user,
            'event_reminder',
            'Recordatorio de evento',
            "El evento '{$event->post->title}' comienza pronto",
            "/events/{$event->id}"
        );
    }
}