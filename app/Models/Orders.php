<?php

namespace App\Models;

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
        'payment_proof',
        'status',
        
        'order_number',
        'snap_token',
        'tax',
        'paid_at',
        'shipping_method',
        'discount_member',   // tambahan komisi
        'commission_earned', // tambahan komisi
        'komisi_digunakan',  // tambahan komisi
        'status_detail', 
        'kurir_name', 
        'estimated_arrival'
    ];

    protected $casts = [
        'subtotal'          => 'decimal:2',
        'shipping_cost'     => 'decimal:2',
        'total'             => 'decimal:2',
        'tax'               => 'decimal:2',
        'discount_member'   => 'decimal:2',
        'commission_earned' => 'decimal:2',
        'komisi_digunakan'  => 'decimal:2',
        'paid_at'           => 'datetime',
    ];

    // ==========================================
    // RELASI (existing)
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

    // ==========================================
    // ACCESSOR
    // ==========================================

    /**
     * Apakah order ini mendapat diskon member?
     */
    public function getIsMemberOrderAttribute(): bool
    {
        return $this->discount_member > 0;
    }

    /**
     * Total yang harus dibayar setelah dikurangi komisi yang digunakan
     */
    public function getTotalAfterKomisiAttribute(): float
    {
        return max(0, $this->total - $this->komisi_digunakan);
    }

    // ==========================================
    // METHODS KOMISI
    // ==========================================

    /**
     * Hitung diskon dan komisi berdasarkan subtotal + rate dari settings
     * Dipanggil saat checkout jika user adalah member
     *
     * Contoh: subtotal 100.000, rate 8 → diskon 8.000, komisi 8.000
     *
     * @param float $subtotal       Subtotal order sebelum diskon
     * @param float $commissionRate Persentase komisi (misal: 8 untuk 8%)
     * @return array ['discount' => ..., 'commission' => ...]
     */
    public static function hitungKomisi(float $subtotal, float $commissionRate): array
    {
        $discount = round($subtotal * ($commissionRate / 100), 2);

        return [
            'discount'   => $discount,
            'commission' => $discount, // komisi = nominal diskon yang diberikan
        ];
    }

    /**
     * Proses pemberian komisi ke user setelah order paid
     * Dipanggil di controller saat status order diubah ke 'paid'
     *
     * ⚠️  Jangan panggil method ini lebih dari sekali untuk order yang sama!
     */
public function prosesKomisi(): void
{
    if ($this->commission_earned <= 0) {
        return;
    }

    // Guard: cek apakah sudah pernah diproses
    $sudahAda = \App\Models\SaldoLog::where('reference_type', 'order')
        ->where('reference_id', $this->order_id)
        ->exists();

    if ($sudahAda) {
        return;
    }

    $this->user->tambahSaldo(
        amount:      $this->commission_earned,
        description: "Komisi dari order #{$this->order_number}",
        refType:     'order',
        refId:       $this->order_id,
    );
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

    // Tambahkan di bagian RELASI
public function ratings()
{
    return $this->hasMany(Ratings::class, 'order_id', 'order_id');
}
}