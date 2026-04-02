<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Heros extends Model
{
    protected $table = 'heros'; // karena tabelnya 'heros', bukan 'heroes'
    protected $primaryKey = 'hero_id';

    protected $fillable = [
        'section',
        'label',
        'headline',
        'subheadline',
        'photo',
        'button_text',
        'button_link',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
