<?php

namespace App\Models;
use App\Models\Notification;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'user_id',
        'shipping_address',
        'subtotal',
        'stock_reduced',
        'shipping_cost',
        'total',
        'payment_method',
        'status',
        'order_number',
        'snap_token',
        'tax',
        'paid_at',
        'shipping_method',
        'discount_member',
        'commission_earned',
        'komisi_digunakan',
        'status_detail',
        'kurir_name',
        'estimated_arrival',
        'shipped_at',
        'completed_at',
        'tracking_number',
        'cash_amount_received',
        'cash_change',
        'ready_at',
        'created_by',
    ];

    protected $casts = [
        'subtotal'             => 'decimal:2',
        'shipping_cost'        => 'decimal:2',
        'total'                => 'decimal:2',
        'tax'                  => 'decimal:2',
        'discount_member'      => 'decimal:2',
        'commission_earned'    => 'decimal:2',
        'komisi_digunakan'     => 'decimal:2',
        'cash_amount_received' => 'decimal:2',
        'cash_change'          => 'decimal:2',
        'paid_at'              => 'datetime',
        'shipped_at'           => 'datetime',
        'completed_at'         => 'datetime',
        'ready_at'             => 'datetime',
    ];

    // ==========================================
    // RELASI
    // ==========================================

    public function items()
    {
        return $this->hasMany(OrderItems::class, 'order_id', 'order_id');
    }

    public function shipping()
    {
        return $this->belongsTo(Shippings::class, 'shipping_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function ratings()
    {
        return $this->hasMany(Ratings::class, 'order_id', 'order_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    // ==========================================
    // ACCESSOR
    // ==========================================

    public function getIsMemberOrderAttribute(): bool
    {
        return $this->discount_member > 0;
    }

    public function getTotalAfterKomisiAttribute(): float
    {
        return max(0, $this->total - $this->komisi_digunakan);
    }

    public function getIsPickupAttribute(): bool
    {
        return $this->shipping_method === 'pickup';
    }

    public function getStatusLabelAttribute(): string
    {
        $labels = [
            'pending'      => 'Menunggu Pembayaran',
            'paid'         => 'Pembayaran Dikonfirmasi',
            'processing'   => 'Sedang Diproses',
            'ready_pickup' => 'Siap Diambil',
            'shipped'      => 'Dikirim',
            'completed'    => 'Selesai',
            'cancelled'    => 'Dibatalkan',
        ];

        return $labels[$this->status] ?? ucfirst($this->status);
    }

    public function getStatusColorAttribute(): string
    {
        $colors = [
            'pending'      => 'warning',
            'paid'         => 'info',
            'processing'   => 'primary',
            'ready_pickup' => 'info',
            'shipped'      => 'primary',
            'completed'    => 'success',
            'cancelled'    => 'danger',
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * Daftar status berikutnya yang valid.
     *
     * Semua metode pembayaran wajib lewat status 'paid' dulu sebelum 'processing'.
     *
     * pickup    : pending → paid → processing → ready_pickup → completed
     * gojek     : pending → paid → processing → completed
     * ekspedisi : pending → paid → processing → shipped → completed
     */
    public function getNextStatusesAttribute(): array
    {
        if ($this->shipping_method === 'pickup') {
            $flow = [
                'pending'      => ['paid', 'cancelled'],
                'paid'         => ['processing', 'cancelled'],
                'processing'   => ['ready_pickup', 'cancelled'],
                'ready_pickup' => ['completed', 'cancelled'],
                'completed'    => [],
                'cancelled'    => [],
            ];
        } elseif ($this->shipping_method === 'gojek') {
            $flow = [
                'pending'    => ['paid', 'cancelled'],
                'paid'       => ['processing', 'cancelled'],
                'processing' => ['completed', 'cancelled'],
                'completed'  => [],
                'cancelled'  => [],
            ];
        } else {
            // ekspedisi
            $flow = [
                'pending'    => ['paid', 'cancelled'],
                'paid'       => ['processing', 'cancelled'],
                'processing' => ['shipped', 'cancelled'],
                'shipped'    => ['completed', 'cancelled'],
                'completed'  => [],
                'cancelled'  => [],
            ];
        }

        return $flow[$this->status] ?? [];
    }

    // ==========================================
    // METHODS KOMISI
    // ==========================================

    public static function hitungKomisi(float $subtotal, float $commissionRate): array
    {
        $discount = round($subtotal * ($commissionRate / 100), 2);

        return [
            'discount'   => $discount,
            'commission' => $discount,
        ];
    }

    public function prosesKomisi(): void
    {
        if ($this->commission_earned > 0) {
            Notification::create([
                'user_id'  => $this->user_id,
                'type'     => 'commission',
                'title'    => 'Komisi Diterima',
                'message'  => 'Kamu mendapat komisi Rp '
                             . number_format($this->commission_earned, 0, ',', '.')
                             . ' dari pesanan #' . $this->order_number . '.',
                'url'      => '/withdrawal',
                'is_read'  => false,
            ]);
        }
    }

    // ==========================================
    // SCOPES
    // ==========================================

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }
}