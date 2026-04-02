<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak mengikuti standar plural Laravel
    protected $table = 'product_images';

    // Penting: Karena kamu menggunakan 'image_id' sebagai Primary Key di migration
    protected $primaryKey = 'image_id';

    protected $fillable = [
        'product_id',
        'photo',      // Sesuaikan dengan nama kolom di migration ('photo')
        'is_primary'
    ];

    public function getPhotoUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->photo);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
