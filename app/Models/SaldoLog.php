<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaldoLog extends Model
{
    protected $primaryKey = 'saldo_log_id';

    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'saldo_before',
        'saldo_after',
        'description',
        'reference_type',
        'reference_id',
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'saldo_before' => 'decimal:2',
        'saldo_after'  => 'decimal:2',
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

    public function getIsKreditAttribute(): bool
    {
        return $this->type === 'credit';
    }

    public function getIsDebitAttribute(): bool
    {
        return $this->type === 'debit';
    }

    /**
     * Format amount dengan tanda + atau -
     * Contoh: "+Rp 2.000" atau "-Rp 5.000"
     */
    public function getAmountFormattedAttribute(): string
    {
        $prefix = $this->type === 'credit' ? '+' : '-';
        return $prefix . 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    // ==========================================
    // SCOPES
    // ==========================================

    public function scopeKredit($query)
    {
        return $query->where('type', 'credit');
    }

    public function scopeDebit($query)
    {
        return $query->where('type', 'debit');
    }

    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }
}