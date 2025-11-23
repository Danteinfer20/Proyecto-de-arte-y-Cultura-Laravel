<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PostMedia
 *
 * @property int $id
 * @property int $post_id
 * @property string $media_path
 * @property string $media_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $file_base_name
 * @property-read mixed $file_url
 * @property-read \App\Models\Post $post
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia whereMediaPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia whereMediaType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMedia whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PostMedia extends Model
{
    use HasFactory;

    // 🔐 Campos permitidos para asignación masiva
    protected $fillable = [
        'post_id',
        'file_type',
        'file_path',
        'file_name',
        'file_size',
        'sort_order',
        'alt_text',
        'is_cover'
    ];

    // 🎛 Casts para datos correctos
    protected $casts = [
        'file_size' => 'integer',
        'sort_order' => 'integer',
        'is_cover' => 'boolean',
    ];

    // 📌 Tipos permitidos
    const TYPES = ['image', 'video', 'audio', 'document'];

    // 🔗 Relación: cada media pertenece a un post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // 📁 Obtener URL completa del archivo
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    // 🏷 Obtener solo el nombre del archivo sin extensión
    public function getFileBaseNameAttribute()
    {
        return pathinfo($this->file_name, PATHINFO_FILENAME);
    }

    // 🖼 Detectar si es imagen
    public function isImage()
    {
        return $this->file_type === 'image';
    }

    // 🎬 Detectar si es video
    public function isVideo()
    {
        return $this->file_type === 'video';
    }

    // 🔊 Detectar si es audio
    public function isAudio()
    {
        return $this->file_type === 'audio';
    }

    // 📄 Detectar si es documento
    public function isDocument()
    {
        return $this->file_type === 'document';
    }

    // ✔ Validar si el tipo es válido
    public function isValidType()
    {
        return in_array($this->file_type, self::TYPES);
    }

    // 📌 Orden por defecto si quieres cargar post->media ordenado
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}
