<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            FaqSeeder::class,
            ServiceSeeder::class,
            PortfolioSeeder::class,
HeroSeeder::class,
PrintingDataSeeder::class,
        ]);
    }
}