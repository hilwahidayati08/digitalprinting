<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HeroSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('heros')->insert([
            // Data untuk Section Hero
            [
                'section' => 'hero',
                'label' => 'Percetakan Digital',
                'headline' => 'Cetak Cepat & Berkualitas',
                'subheadline' => 'Solusi cetak banner, stiker, dan kartu nama hanya dalam satu klik dengan harga terbaik.',
                'photo' => 'hero_banner.jpg',
                'button_link' => '/products',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Data untuk Section About
            [
                'section' => 'about',
                'label' => 'Tentang Kami',
                'headline' => 'Pengalaman Sejak 2010',
                'subheadline' => 'Kami adalah mitra terpercaya untuk segala kebutuhan digital printing Anda, mengutamakan kepuasan pelanggan dan ketajaman warna.',
                'photo' => 'about.jpg',
                'button_link' => '/about-us',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}