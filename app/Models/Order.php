<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'status',
        'payment_method',
        'shipping_address',
        'contact_phone',
        'notes'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /* ============================
     *    RELACIONES
     * ============================ */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /* ============================
     *    ESTADOS DE PEDIDO
     * ============================ */

    public static function getStatusTypes(): array
    {
        return [
            'pending' => '⏳ Pendiente',
            'confirmed' => '✅ Confirmada',
            'shipped' => '🚚 Enviada',
            'delivered' => '📦 Entregada',
            'cancelled' => '❌ Cancelada'
        ];
    }

    public static function getPaymentMethods(): array
    {
        return [
            'cash' => '💵 Efectivo',
            'card' => '💳 Tarjeta',
            'transfer' => '🏦 Transferencia',
            'digital_wallet' => '📱 Billetera Digital',
        ];
    }

    /* ============================
     *    MÉTODOS ÚTILES
     * ============================ */

    public function getStatusNameAttribute(): string
    {
        return self::getStatusTypes()[$this->status] ?? $this->status;
    }

    public function getPaymentMethodNameAttribute(): string
    {
        return self::getPaymentMethods()[$this->payment_method] ?? $this->payment_method;
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    public function isShipped(): bool
    {
        return $this->status === 'shipped';
    }

    public function isDelivered(): bool
    {
        return $this->status === 'delivered';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    public function canBeModified(): bool
    {
        return $this->isPending();
    }

    public function getItemsCountAttribute(): int
    {
        return $this->items()->sum('quantity');
    }

    public function getUniqueProductsCountAttribute(): int
    {
        return $this->items()->count();
    }

    /* ============================
     *    GESTIÓN DE ESTADOS
     * ============================ */

    public function markAsConfirmed(): bool
    {
        if ($this->isPending()) {
            return $this->update(['status' => 'confirmed']);
        }
        return false;
    }

    public function markAsShipped(): bool
    {
        if ($this->isConfirmed()) {
            return $this->update(['status' => 'shipped']);
        }
        return false;
    }

    public function markAsDelivered(): bool
    {
        if ($this->isShipped()) {
            return $this->update(['status' => 'delivered']);
        }
        return false;
    }

    public function cancel(): bool
    {
        if ($this->canBeCancelled()) {
            return $this->update(['status' => 'cancelled']);
        }
        return false;
    }

    /* ============================
     *    GESTIÓN DE ITEMS
     * ============================ */

    public function addProduct(Product $product, int $quantity = 1): OrderItem
    {
        $unitPrice = $product->getCurrentPrice();
        $subtotal = $unitPrice * $quantity;

        $orderItem = $this->items()->create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'subtotal' => $subtotal,
        ]);

        $this->updateTotal();

        return $orderItem;
    }

    public function updateTotal(): void
    {
        $total = $this->items()->sum('subtotal');
        $this->update(['total_amount' => $total]);
    }

    public function recalculateTotals(): void
    {
        $this->items->each(function ($item) {
            $item->update([
                'subtotal' => $item->quantity * $item->unit_price
            ]);
        });
        
        $this->updateTotal();
    }

    /* ============================
     *    GENERACIÓN DE NÚMEROS
     * ============================ */

    public static function generateOrderNumber(): string
    {
        $prefix = 'ORD';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -6));

        return $prefix . $date . $random;
    }

    /* ============================
     *    SCOPES
     * ============================ */

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeShipped($query)
    {
        return $query->where('status', 'shipped');
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeWithHighValue($query, float $minAmount = 100000)
    {
        return $query->where('total_amount', '>=', $minAmount);
    }

    /* ============================
     *    HOOKS DEL MODELO
     * ============================ */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = self::generateOrderNumber();
            }
        });

        static::updating(function ($order) {
            if ($order->isDirty('user_id') && $order->exists) {
                throw new \Exception("No se puede cambiar el usuario de un pedido existente.");
            }
        });
    }
}