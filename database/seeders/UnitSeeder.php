<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            'Pcs',
            'Meter',
            'Lembar',
            'Pack'
        ];

        foreach ($units as $unit) {
            Unit::create([
                'name' => $unit,
                'is_active' => 1,
            ]);
        }
    }
}