<?php

namespace Database\Seeders;

use App\Models\POrtofolios;
use Illuminate\Database\Seeder;
use App\Models\Portfolio;
use Illuminate\Support\Str;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'title' => 'Cetak Banner UMKM',
                'photo' => 'banner-umkm.jpg',
                'description' => 'Proyek cetak banner promosi untuk UMKM lokal dengan bahan flexi berkualitas.',
            ],
            [
                'title' => 'Desain & Cetak Brosur Sekolah',
                'photo' => 'brosur-sekolah.jpg',
                'description' => 'Desain dan cetak brosur penerimaan siswa baru dengan full color printing.',
            ],
            [
                'title' => 'Cetak Kartu Nama Premium',
                'photo' => 'kartu-nama.jpg',
                'description' => 'Kartu nama dengan bahan art carton 310gsm dan finishing laminasi doff.',
            ],
            [
                'title' => 'Cetak Spanduk Event',
                'photo' => 'panduk-event.jpg',
                'description' => 'Spanduk ukuran besar untuk kebutuhan event dan promosi outdoor.',
            ],
            [
                'title' => 'Custom Sticker Branding',
                'photo' => 'sticker-branding.jpg',
                'description' => 'Sticker custom untuk branding produk dengan cutting presisi.',
            ],
        ];

        foreach ($data as $item) {
            Portofolios::create([
                'title' => $item['title'],
                'photo' => $item['photo'],
                'description' => $item['description'],
                'slug' => Str::slug($item['title']),
                'is_active' => 1,
            ]);
        }
    }
}