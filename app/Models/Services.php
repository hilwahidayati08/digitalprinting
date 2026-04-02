<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'service_id';

    protected $fillable = [
        'service_name',
        'icon',
        'description',
        'is_active'

    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
