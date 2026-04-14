<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{
    protected $primaryKey = 'withdrawal_id';

    protected $fillable = [
        'user_id',
        'amount',
        'bank_name',
        'account_number',
        'account_name',
        'status',
        'processed_at',
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    // ==========================================
    // RELASI
    // ==========================================

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // ==========================================
    // ACCESSOR
    // ==========================================

    public function getIsPendingAttribute(): bool
    {
        return $this->status === 'pending';
    }

    public function getIsApprovedAttribute(): bool
    {
        return $this->status === 'approved';
    }

    public function getIsRejectedAttribute(): bool
    {
        return $this->status === 'rejected';
    }

    public function getAmountFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'  => '⏳ Menunggu',
            'approved' => '✅ Disetujui',
            'rejected' => '❌ Ditolak',
            default    => $this->status,
        };
    }

    // ==========================================
    // METHODS
    // ==========================================

    /**
     * Admin approve withdraw
     * Saldo baru dikurangi di sini — bukan saat request dibuat!
     *
     * @throws \Exception jika saldo tidak mencukupi
     */
public function approve(): void
{
    $user = $this->user->fresh();

    if (!$user->saldoCukup($this->amount)) {
        throw new \Exception('Saldo komisi user tidak mencukupi untuk dicairkan.');
    }

    $user->kurangiSaldo(
        amount:      $this->amount,
        description: "Withdraw ke {$this->bank_name} {$this->account_number}",
        refType:     'withdrawal',
        refId:       $this->withdrawal_id,
    );

    $this->update([
        'status'       => 'approved',
        'processed_at' => now(),
    ]);

    // ← TAMBAHKAN INI
    \App\Models\Notification::create([
        'type'    => 'withdrawal',
        'title'   => '💸 Withdraw Disetujui',
        'message' => "Withdraw {$this->amount_formatted} untuk {$user->username} telah disetujui.",
        'url'     => '/admin/withdrawals',
        'is_read' => 0,
    ]);
}

    /**
     * Admin reject withdraw — saldo tidak terpengaruh
     */


    // ==========================================
    // SCOPES
    // ==========================================

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }
}