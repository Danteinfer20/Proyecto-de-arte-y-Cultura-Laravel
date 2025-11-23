<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path', 
        'sort_order', // CORRECCIÓN: Campo agregado
        'alt_text',
        'is_primary'
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_primary' => 'boolean',
    ];

    /* ============================
     *    RELACIONES
     * ============================ */

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /* ============================
     *    MÉTODOS ÚTILES
     * ============================ */

    public function isPrimary(): bool
    {
        return $this->is_primary;
    }

    public function setAsPrimary(): bool
    {
        // Primero, quitar primary de otras imágenes del mismo producto
        self::where('product_id', $this->product_id)
            ->where('id', '!=', $this->id)
            ->update(['is_primary' => false]);

        // Luego marcar esta como primary
        return $this->update(['is_primary' => true]);
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        
        return asset('images/default-product.png');
    }

    public function hasAltText(): bool
    {
        return !empty($this->alt_text);
    }

    public function getDisplayAltTextAttribute(): string
    {
        return $this->alt_text ?: 'Imagen de producto';
    }

    public function getSortOrderAttribute(): int
    {
        return $this->attributes['sort_order'] ?? 0;
    }

    public function moveUp(): bool
    {
        if ($this->sort_order > 0) {
            $previousImage = self::where('product_id', $this->product_id)
                                ->where('sort_order', $this->sort_order - 1)
                                ->first();
            
            if ($previousImage) {
                $previousImage->update(['sort_order' => $this->sort_order]);
            }
            
            return $this->update(['sort_order' => $this->sort_order - 1]);
        }
        
        return false;
    }

    public function moveDown(): bool
    {
        $maxOrder = self::where('product_id', $this->product_id)->max('sort_order');
        
        if ($this->sort_order < $maxOrder) {
            $nextImage = self::where('product_id', $this->product_id)
                            ->where('sort_order', $this->sort_order + 1)
                            ->first();
            
            if ($nextImage) {
                $nextImage->update(['sort_order' => $this->sort_order]);
            }
            
            return $this->update(['sort_order' => $this->sort_order + 1]);
        }
        
        return false;
    }

    /* ============================
     *    SCOPES
     * ============================ */

    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    public function scopeByProduct($query, int $productId)
    {
        return $query->where('product_id', $productId);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function scopeSecondary($query)
    {
        return $query->where('is_primary', false);
    }

    /* ============================
     *    MÉTODOS ESTÁTICOS
     * ============================ */

    public static function getNextSortOrder(int $productId): int
    {
        $maxOrder = self::where('product_id', $productId)->max('sort_order');
        return ($maxOrder ?? -1) + 1;
    }

    public static function createForProduct(Product $product, string $imagePath, string $altText = '', bool $isPrimary = false): self
    {
        // Si es primary, quitar primary de otras imágenes
        if ($isPrimary) {
            self::where('product_id', $product->id)->update(['is_primary' => false]);
        }

        return self::create([
            'product_id' => $product->id,
            'image_path' => $imagePath,
            'alt_text' => $altText,
            'is_primary' => $isPrimary,
            'sort_order' => self::getNextSortOrder($product->id),
        ]);
    }

    /* ============================
     *    HOOKS
     * ============================ */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($image) {
            if (is_null($image->sort_order)) {
                $image->sort_order = self::getNextSortOrder($image->product_id);
            }
        });

        static::deleting(function ($image) {
            // Si se elimina la imagen primary, asignar otra como primary
            if ($image->is_primary) {
                $newPrimary = self::where('product_id', $image->product_id)
                                 ->where('id', '!=', $image->id)
                                 ->first();
                
                if ($newPrimary) {
                    $newPrimary->update(['is_primary' => true]);
                }
            }
        });
    }
}