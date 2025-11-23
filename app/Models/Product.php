<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description',
        'price',
        'sale_price',
        'stock_quantity',
        'product_type',
        'dimensions',
        'materials',
        'weight_kg',
        'main_image',
        'status',
        'is_featured',
        'sales_count',
        'slug'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'weight_kg' => 'decimal:2',
        'stock_quantity' => 'integer',
        'sales_count' => 'integer',
        'is_featured' => 'boolean',
    ];

    /* ============================
     *    RELACIONES
     * ============================ */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /* ============================
     *    TIPOS DE PRODUCTOS
     * ============================ */

    public static function getProductTypes(): array
    {
        return [
            'physical' => '🛍️ Producto Físico',
            'digital' => '💻 Producto Digital', 
            'service' => '🔧 Servicio',
            'handicraft' => '🎨 Artesanía',
        ];
    }

    public static function getStatusTypes(): array
    {
        return [
            'available' => '🟢 Disponible',
            'sold_out' => '🔴 Agotado',
            'paused' => '⏸️ Pausado',
        ];
    }

    /* ============================
     *    MÉTODOS ÚTILES
     * ============================ */

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function isSoldOut(): bool
    {
        return $this->status === 'sold_out';
    }

    public function isPaused(): bool
    {
        return $this->status === 'paused';
    }

    public function hasStock(): bool
    {
        return $this->stock_quantity > 0;
    }

    public function hasSalePrice(): bool
    {
        return !is_null($this->sale_price) && $this->sale_price > 0;
    }

    public function getCurrentPrice(): float
    {
        return $this->hasSalePrice() ? $this->sale_price : $this->price;
    }

    public function getDiscountPercentage(): ?int
    {
        if (!$this->hasSalePrice()) {
            return null;
        }

        return (int) round((($this->price - $this->sale_price) / $this->price) * 100);
    }

    public function isOnSale(): bool
    {
        return $this->hasSalePrice() && $this->sale_price < $this->price;
    }

    public function decrementStock(int $quantity = 1): void
    {
        $this->decrement('stock_quantity', $quantity);
        
        if ($this->stock_quantity <= 0) {
            $this->update(['status' => 'sold_out']);
        }
    }

    public function incrementSalesCount(int $quantity = 1): void
    {
        $this->increment('sales_count', $quantity);
    }

    public function getTypeNameAttribute(): string
    {
        return self::getProductTypes()[$this->product_type] ?? $this->product_type;
    }

    public function getStatusNameAttribute(): string
    {
        return self::getStatusTypes()[$this->status] ?? $this->status;
    }

    /* ============================
     *    SCOPES
     * ============================ */

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOnSale($query)
    {
        return $query->whereNotNull('sale_price')
                    ->whereColumn('sale_price', '<', 'price');
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('product_type', $type);
    }

    public function scopeHandicrafts($query)
    {
        return $this->scopeByType($query, 'handicraft');
    }

    public function scopePhysical($query)
    {
        return $this->scopeByType($query, 'physical');
    }

    public function scopeDigital($query)
    {
        return $this->scopeByType($query, 'digital');
    }

    public function scopeServices($query)
    {
        return $this->scopeByType($query, 'service');
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    public function scopeLowStock($query, int $threshold = 5)
    {
        return $query->where('stock_quantity', '<=', $threshold)
                    ->where('stock_quantity', '>', 0);
    }
}