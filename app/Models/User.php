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
        'is_member',
        'saldo_komisi',
        'member_tier',
        'total_spent',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password'                 => 'hashed',
        'is_member'                => 'boolean',
        'saldo_komisi'             => 'decimal:2',
        'total_spent'              => 'decimal:2',
    ];

    // ==========================================
    // RELASI
    // ==========================================
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'user_id');
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

    public function getTierLabelAttribute(): string
    {
        return match ($this->member_tier) {
            'plus'    => '⭐ Plus',
            'premium' => '💎 Premium',
            default   => '🥉 Regular',
        };
    }

    public function getTierColorAttribute(): string
    {
        return match ($this->member_tier) {
            'plus'    => 'bg-blue-100 text-blue-700',
            'premium' => 'bg-yellow-100 text-yellow-700',
            default   => 'bg-gray-100 text-gray-600',
        };
    }
        public function isGoogleAccount(): bool
    {
        return !is_null($this->google_id) && is_null($this->password);
    }

public function hasPassword(): bool
{
    return !is_null($this->password);
}

// TAMBAHKAN method baru ini di User.php
public function getCommissionRate(): float
{
    $settings = Settings::first();
    if (!$settings) return 0.0;

    return match ($this->member_tier) {
        'premium' => (float) $settings->rate_premium,
        'plus'    => (float) $settings->rate_plus,
        default   => (float) $settings->rate_regular,
    };
}
    // ==========================================
    // METHODS
    // ==========================================

    /**
     * Tambah saldo komisi + catat di saldo_logs
     */
    public function tambahSaldo(
        float $amount,
        string $description,
        string $refType = null,
        int $refId = null
    ): void {
        $saldoBefore = (float) $this->saldo_komisi;
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
     * Kurangi saldo komisi + catat di saldo_logs
     *
     * @throws \Exception jika saldo tidak cukup
     */
    public function kurangiSaldo(
        float $amount,
        string $description,
        string $refType = null,
        int $refId = null
    ): void {
        if ($this->saldo_komisi < $amount) {
            throw new \Exception('Saldo komisi tidak mencukupi.');
        }

        $saldoBefore = (float) $this->saldo_komisi;
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

    public function saldoCukup(float $amount): bool
    {
        return $this->saldo_komisi >= $amount;
    }

    /**
     * Syarat daftar member: DIHAPUS per permintaan.
     * Sekarang siapapun boleh daftar member — return true saja.
     * Method ini tetap ada agar view/controller yang sudah pakai
     * bisaAjukanMember() tidak error.
     */
    public function bisaAjukanMember(): bool
    {
        return true;
    }

    /**
     * Hitung ulang total_spent & naikkan tier otomatis.
     * Dipanggil setiap kali order selesai dibayar (status paid).
     */
    public function updateTierOtomatis(): void
    {
        if (!$this->is_member) return;

        $settings = Settings::first();
        if (!$settings) return;

        // Hitung dari DB langsung agar selalu akurat
        $totalSpent = $this->orders()
            ->whereIn('status', ['paid', 'processing', 'shipped', 'delivered'])
            ->sum('total');

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