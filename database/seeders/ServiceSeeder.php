<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Services;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        Services::insert([
            [
                'service_name' => 'Desain Grafis',
                'icon' => 'design.png',
                'description' => 'Layanan desain profesional untuk kebutuhan branding, logo, dan materi promosi bisnis Anda.',
                'is_active' => 1,
            ],
            [
                'service_name' => 'Digital Printing',
                'icon' => 'printing.png',
                'description' => 'Cetak cepat dengan kualitas warna tajam untuk brosur, banner, poster, dan kebutuhan promosi lainnya.',
                'is_active' => 1,
            ],
            [
                'service_name' => 'Kartu Nama Eksklusif',
                'icon' => 'business-card.png',
                'description' => 'Kartu nama premium dengan berbagai pilihan bahan dan finishing elegan.',
                'is_active' => 1,
            ],
            [
                'service_name' => 'Stiker & Label Custom',
                'icon' => 'sticker.png',
                'description' => 'Cetak stiker dan label custom berbagai ukuran dengan hasil tahan lama dan berkualitas.',
                'is_active' => 1,
            ],
        ]);
    }
}