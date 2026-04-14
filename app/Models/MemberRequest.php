<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberRequest extends Model
{
    protected $primaryKey = 'request_id';

    protected $fillable = [
        'user_id',
        'status',
        'processed_at',
    ];

    protected $casts = [
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
     * Admin approve → otomatis set is_member = true di tabel users
     */
    public function approve(): void
    {
        $this->update([
            'status'       => 'approved',
            'processed_at' => now(),
        ]);

        $this->user->update(['is_member' => true]);
    }

    /**
     * Admin reject pengajuan member
     */
    public function reject(string $reason = null): void
    {
        $this->update([
            'status'           => 'rejected',
            'processed_at'     => now(),
        ]);
    }

    // ==========================================
    // SCOPES
    // ==========================================

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}