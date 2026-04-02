<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table      = 'users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'username',
        'useremail',
        'password',
        'no_telp',
        'full_name',
        'role',
        'google_id',
        'is_member',               // komisi
        'saldo_komisi',            // komisi
        'member_tier',             // tier: regular / plus / premium
        'commission_rate_override',// override rate khusus per member (opsional, diset admin)
        'total_spent',             // total belanja kumulatif untuk hitung tier otomatis
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password'                 => 'hashed',
        'is_member'                => 'boolean',
        'saldo_komisi'             => 'decimal:2',
        'commission_rate_override' => 'decimal:2',
        'total_spent'              => 'decimal:2',
    ];

    // ==========================================
    // RELASI
    // ==========================================
// Tambahkan di Model User.php
public function getActiveRate()
{
    // Cek Jalur Khusus dulu
    if ($this->commission_rate_override) {
        return $this->commission_rate_override;
    }

    // Ambil rate dari tabel settings
    $setup = \App\Models\Settings::first();

    return match($this->member_tier) {
        'premium' => $setup->rate_premium, // Mengambil 15,0
        'plus'    => $setup->rate_plus,    // Mengambil 10,0
        default   => $setup->rate_regular, // Mengambil 5,0
    };
}
    public function profile()
    {
        return $this->hasOne(Profiles::class, 'user_id');
    }

    public function shippings()
    {
        return $this->hasMany(Shippings::class);
    }

    public function cart()
    {
        return $this->hasOne(Carts::class);
    }

    public function orders()
    {
        return $this->hasMany(Orders::class, 'user_id', 'user_id');
    }

    public function memberRequest()
    {
        return $this->hasOne(MemberRequest::class, 'user_id', 'user_id')
                    ->latest();
    }

    public function memberRequests()
    {
        return $this->hasMany(MemberRequest::class, 'user_id', 'user_id');
    }

    public function withdrawalRequests()
    {
        return $this->hasMany(WithdrawalRequest::class, 'user_id', 'user_id');
    }

    public function saldoLogs()
    {
        return $this->hasMany(SaldoLog::class, 'user_id', 'user_id')
                    ->latest();
    }

    // ==========================================
    // ACCESSOR
    // ==========================================

    public function getIsAdminAttribute(): bool
    {
        return $this->role === 'admin';
    }

    public function getSaldoKomisiFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->saldo_komisi, 0, ',', '.');
    }

    /**
     * Label tier untuk ditampilkan di UI
     * Contoh: $user->tier_label → "⭐ Plus"
     */
    public function getTierLabelAttribute(): string
    {
        return match ($this->member_tier) {
            'plus'    => '⭐ Plus',
            'premium' => '💎 Premium',
            default   => '🥉 Regular',
        };
    }

    /**
     * Warna badge tier (Tailwind class)
     * Contoh: $user->tier_color → "bg-blue-100 text-blue-700"
     */
    public function getTierColorAttribute(): string
    {
        return match ($this->member_tier) {
            'plus'    => 'bg-blue-100 text-blue-700',
            'premium' => 'bg-yellow-100 text-yellow-700',
            default   => 'bg-gray-100 text-gray-600',
        };
    }

    /**
     * Rate komisi aktif untuk member ini.
     * Prioritas: override admin → rate tier dari settings
     * Contoh: $user->active_commission_rate → 10.0
     */
    public function getActiveCommissionRateAttribute(): float
    {
        // Jika admin set override khusus untuk member ini, pakai itu
        if (!is_null($this->commission_rate_override)) {
            return (float) $this->commission_rate_override;
        }

        // Ambil rate sesuai tier dari settings
        $settings = Settings::first();
        if (!$settings) return 5.0;

        return match ($this->member_tier) {
            'plus'    => (float) $settings->rate_plus,
            'premium' => (float) $settings->rate_premium,
            default   => (float) $settings->rate_regular,
        };
    }

    // ==========================================
    // METHODS KOMISI
    // ==========================================

    /**
     * Tambah saldo komisi + otomatis catat di saldo_logs
     */
    public function tambahSaldo(float $amount, string $description, string $refType = null, int $refId = null): void
    {
        $saldoBefore = $this->saldo_komisi;
        $saldoAfter  = $saldoBefore + $amount;

        $this->increment('saldo_komisi', $amount);

        SaldoLog::create([
            'user_id'        => $this->user_id,
            'type'           => 'credit',
            'amount'         => $amount,
            'saldo_before'   => $saldoBefore,
            'saldo_after'    => $saldoAfter,
            'description'    => $description,
            'reference_type' => $refType,
            'reference_id'   => $refId,
        ]);
    }

    /**
     * Kurangi saldo komisi + otomatis catat di saldo_logs
     *
     * @throws \Exception jika saldo tidak cukup
     */
    public function kurangiSaldo(float $amount, string $description, string $refType = null, int $refId = null): void
    {
        if ($this->saldo_komisi < $amount) {
            throw new \Exception('Saldo komisi tidak mencukupi.');
        }

        $saldoBefore = $this->saldo_komisi;
        $saldoAfter  = $saldoBefore - $amount;

        $this->decrement('saldo_komisi', $amount);

        SaldoLog::create([
            'user_id'        => $this->user_id,
            'type'           => 'debit',
            'amount'         => $amount,
            'saldo_before'   => $saldoBefore,
            'saldo_after'    => $saldoAfter,
            'description'    => $description,
            'reference_type' => $refType,
            'reference_id'   => $refId,
        ]);
    }

    /**
     * Cek apakah saldo cukup untuk nominal tertentu
     */
    public function saldoCukup(float $amount): bool
    {
        return $this->saldo_komisi >= $amount;
    }

    /**
     * Cek apakah user memenuhi syarat untuk ajukan member
     * Syarat: minimal X order ATAU total belanja minimal Rp X (dari settings)
     */
    public function bisaAjukanMember(): bool
    {
        $settings = Settings::first();
        if (!$settings) return false;

        $totalOrders = $this->orders()
            ->whereIn('status', ['paid', 'processing', 'shipped', 'delivered'])
            ->count();

        $totalSpent = $this->orders()
            ->whereIn('status', ['paid', 'processing', 'shipped', 'delivered'])
            ->sum('total');

        return $totalOrders >= $settings->member_min_orders
            || $totalSpent  >= $settings->member_min_spent;
    }

    /**
     * Update total_spent dan naikan tier otomatis.
     * Dipanggil setiap kali order statusnya jadi paid.
     */
    public function updateTierOtomatis(): void
    {
        if (!$this->is_member) return;

        $settings = Settings::first();
        if (!$settings) return;

        // Hitung ulang total belanja dari semua order paid
        $totalSpent = $this->orders()
            ->whereIn('status', ['paid', 'processing', 'shipped', 'delivered'])
            ->sum('total');

        // Tentukan tier baru
        $tierBaru = 'regular';
        if ($totalSpent >= $settings->tier_premium_min) {
            $tierBaru = 'premium';
        } elseif ($totalSpent >= $settings->tier_plus_min) {
            $tierBaru = 'plus';
        }

        $this->update([
            'total_spent' => $totalSpent,
            'member_tier' => $tierBaru,
        ]);
    }
}