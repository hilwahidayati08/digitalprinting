<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $primaryKey = 'notif_id';
protected $fillable = ['type', 'title', 'message', 'url', 'is_read'];
}
