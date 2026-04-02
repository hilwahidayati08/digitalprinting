<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PasswordResetOtp extends Model
{
    protected $table = 'password_reset_otps';
    protected $primaryKey = 'otp_id';
    
    protected $fillable = [
        'useremail', 'otp_code', 'token', 'expires_at', 'is_used'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean'
    ];
}