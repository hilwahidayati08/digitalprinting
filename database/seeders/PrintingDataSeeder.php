<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrintingDataSeeder extends Seeder
{
    public function run(): void
    {
        // ================================================
        // 1. UNITS
        // ================================================
        $units = [
            ['unit_id' => 1, 'unit_name' => 'Meter'],
            ['unit_id' => 2, 'unit_name' => 'Lembar'],
            ['unit_id' => 3, 'unit_name' => 'Pcs'],
        ];

        foreach ($units as $unit) {
            DB::table('units')->updateOrInsert(
                ['unit_id' => $unit['unit_id']],
                array_merge($unit, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

        $this->command->info('✅ Units selesai.');

        // ================================================
        // 2. CATEGORIES
        // ================================================
        $categories = [
            ['category_id' => 1, 'category_name' => 'Banner & Spanduk', 'slug' => 'banner-spanduk', 'calc_type' => 'luas'],
            ['category_id' => 2, 'category_name' => 'Stiker & Label',   'slug' => 'stiker-label',   'calc_type' => 'stiker'],
            ['category_id' => 3, 'category_name' => 'Kartu Nama',       'slug' => 'kartu-nama',      'calc_type' => 'stiker'],
            ['category_id' => 4, 'category_name' => 'Brosur & Flyer',   'slug' => 'brosur-flyer',    'calc_type' => 'satuan'],
            ['category_id' => 5, 'category_name' => 'Undangan',         'slug' => 'undangan',        'calc_type' => 'satuan'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
                ['category_id' => $category['category_id']],
                array_merge($category, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

        $this->command->info('✅ Categories selesai.');

        // ================================================
        // 3. MATERIALS
        // ================================================
        $materials = [
            [
                'material_id'   => 1,
                'material_name' => 'Flexy China 280gr',
                'material_type' => 'roll',
                'width_cm'      => 0,
                'height_cm'     => 0,
                'spacing_mm'    => 0,
                'stock'         => 500,
                'min_stock'     => 50,
                'unit_id'       => 1,
            ],
            [
                'material_id'   => 2,
                'material_name' => 'Art Paper 260gr A3',
                'material_type' => 'sheet',
                'width_cm'      => 29.7,
                'height_cm'     => 42,
                'spacing_mm'    => 2,
                'stock'         => 500,
                'min_stock'     => 30,
                'unit_id'       => 2,
            ],
            [
                'material_id'   => 3,
                'material_name' => 'Ivory 310gr A3',
                'material_type' => 'sheet',
                'width_cm'      => 29.7,
                'height_cm'     => 42,
                'spacing_mm'    => 2,
                'stock'         => 300,
                'min_stock'     => 30,
                'unit_id'       => 2,
            ],
            [
                'material_id'   => 4,
                'material_name' => 'Art Paper 150gr A4',
                'material_type' => 'sheet',
                'width_cm'      => 21,
                'height_cm'     => 29.7,
                'spacing_mm'    => 0,
                'stock'         => 400,
                'min_stock'     => 40,
                'unit_id'       => 2,
            ],
            [
                'material_id'   => 5,
                'material_name' => 'Fancy Paper A4',
                'material_type' => 'sheet',
                'width_cm'      => 21,
                'height_cm'     => 29.7,
                'spacing_mm'    => 0,
                'stock'         => 150,
                'min_stock'     => 15,
                'unit_id'       => 2,
            ],
            [
                'material_id'   => 6,
                'material_name' => 'Vinyl Glossy A3',
                'material_type' => 'sheet',
                'width_cm'      => 29.7,
                'height_cm'     => 42,
                'spacing_mm'    => 3,
                'stock'         => 200,
                'min_stock'     => 20,
                'unit_id'       => 2,
            ],
        ];

        foreach ($materials as $material) {
            $exists = DB::table('materials')->where('material_id', $material['material_id'])->exists();

            DB::table('materials')->updateOrInsert(
                ['material_id' => $material['material_id']],
                array_merge($material, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );

            // Catat stok awal ke stock_logs hanya jika material baru
            if (!$exists && $material['stock'] > 0) {
                DB::table('stock_logs')->insert([
                    'material_id' => $material['material_id'],
                    'type'        => 'in',
                    'amount'      => $material['stock'],
                    'last_stock'  => $material['stock'],
                    'description' => 'Stok awal material (seeder)',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }

        $this->command->info('✅ Materials selesai.');

        // ================================================
        // 4. PRODUCTS
        // ================================================
        $products = [
            [
                'product_id'        => 1,
                'category_id'       => 1,
                'unit_id'           => 1,
                'material_id'       => 1,
                'product_name'      => 'Banner Flexi Indoor',
                'slug'              => 'banner-flexi-indoor',
                'description'       => 'Banner indoor berkualitas tinggi menggunakan bahan Flexy China 280gr. Cocok untuk dekorasi dalam ruangan, pameran, dan event.',
                'price'             => 45000,
                'is_active'         => 1,
                'production_time'   => 2,
                'default_width_cm'  => null,
                'default_height_cm' => null,
                'allow_custom_size' => 1,
            ],
            [
                'product_id'        => 2,
                'category_id'       => 1,
                'unit_id'           => 1,
                'material_id'       => 1,
                'product_name'      => 'Spanduk Flexi Outdoor',
                'slug'              => 'spanduk-flexi-outdoor',
                'description'       => 'Spanduk outdoor tahan cuaca menggunakan bahan Flexy China 280gr. Tahan panas dan hujan, cocok untuk promosi di luar ruangan.',
                'price'             => 35000,
                'is_active'         => 1,
                'production_time'   => 3,
                'default_width_cm'  => null,
                'default_height_cm' => null,
                'allow_custom_size' => 1,
            ],
            [
                'product_id'        => 3,
                'category_id'       => 2,
                'unit_id'           => 3,
                'material_id'       => 6,
                'product_name'      => 'Stiker Vinyl Glossy',
                'slug'              => 'stiker-vinyl-glossy',
                'description'       => 'Stiker berbahan vinyl glossy, warna cerah dan tahan lama. Cocok untuk stiker produk, branding, dan dekorasi.',
                'price'             => 85000,
                'is_active'         => 1,
                'production_time'   => 1,
                'default_width_cm'  => 10,
                'default_height_cm' => 10,
                'allow_custom_size' => 1,
            ],
            [
                'product_id'        => 4,
                'category_id'       => 2,
                'unit_id'           => 3,
                'material_id'       => 6,
                'product_name'      => 'Stiker Cutting Vinyl',
                'slug'              => 'stiker-cutting-vinyl',
                'description'       => 'Stiker cutting presisi menggunakan vinyl berkualitas. Tersedia berbagai warna, cocok untuk dekorasi motor, mobil, dan dinding.',
                'price'             => 95000,
                'is_active'         => 1,
                'production_time'   => 2,
                'default_width_cm'  => 10,
                'default_height_cm' => 10,
                'allow_custom_size' => 1,
            ],
            [
                'product_id'        => 5,
                'category_id'       => 3,
                'unit_id'           => 3,
                'material_id'       => 3,
                'product_name'      => 'Kartu Nama Ivory Glossy',
                'slug'              => 'kartu-nama-ivory-glossy',
                'description'       => 'Kartu nama premium bahan Ivory 310gr dengan laminasi glossy. Kesan mewah dan profesional untuk bisnis Anda.',
                'price'             => 120000,
                'is_active'         => 1,
                'production_time'   => 2,
                'default_width_cm'  => 9,
                'default_height_cm' => 5.5,
                'allow_custom_size' => 0,
            ],
            [
                'product_id'        => 6,
                'category_id'       => 3,
                'unit_id'           => 3,
                'material_id'       => 3,
                'product_name'      => 'Kartu Nama Laminasi Doff',
                'slug'              => 'kartu-nama-laminasi-doff',
                'description'       => 'Kartu nama elegan dengan laminasi doff anti sidik jari. Tampilan modern dan profesional untuk kebutuhan networking Anda.',
                'price'             => 150000,
                'is_active'         => 1,
                'production_time'   => 3,
                'default_width_cm'  => 9,
                'default_height_cm' => 5.5,
                'allow_custom_size' => 0,
            ],
            [
                'product_id'        => 7,
                'category_id'       => 4,
                'unit_id'           => 3,
                'material_id'       => 4,
                'product_name'      => 'Flyer A5 Art Paper',
                'slug'              => 'flyer-a5-art-paper',
                'description'       => 'Flyer A5 cetak full color menggunakan Art Paper 150gr. Solusi promosi efektif untuk bisnis, event, dan penawaran spesial.',
                'price'             => 75000,
                'is_active'         => 1,
                'production_time'   => 1,
                'default_width_cm'  => 14.8,
                'default_height_cm' => 21,
                'allow_custom_size' => 0,
            ],
            [
                'product_id'        => 8,
                'category_id'       => 4,
                'unit_id'           => 3,
                'material_id'       => 4,
                'product_name'      => 'Brosur A4 Lipat 3',
                'slug'              => 'brosur-a4-lipat-3',
                'description'       => 'Brosur A4 lipat 3 (trifold) cetak full color dua sisi. Ideal untuk company profile, katalog produk, dan media promosi.',
                'price'             => 95000,
                'is_active'         => 1,
                'production_time'   => 2,
                'default_width_cm'  => 21,
                'default_height_cm' => 29.7,
                'allow_custom_size' => 0,
            ],
            [
                'product_id'        => 9,
                'category_id'       => 5,
                'unit_id'           => 3,
                'material_id'       => 5,
                'product_name'      => 'Undangan Pernikahan Fancy',
                'slug'              => 'undangan-pernikahan-fancy',
                'description'       => 'Undangan pernikahan mewah menggunakan Fancy Paper dengan tekstur premium. Tersedia desain custom sesuai keinginan.',
                'price'             => 180000,
                'is_active'         => 1,
                'production_time'   => 3,
                'default_width_cm'  => 19,
                'default_height_cm' => 13,
                'allow_custom_size' => 0,
            ],
            [
                'product_id'        => 10,
                'category_id'       => 5,
                'unit_id'           => 3,
                'material_id'       => 5,
                'product_name'      => 'Undangan Ultah Anak',
                'slug'              => 'undangan-ultah-anak',
                'description'       => 'Undangan ulang tahun anak yang colorful dan menarik. Bahan Fancy Paper berkualitas dengan desain ceria dan lucu.',
                'price'             => 130000,
                'is_active'         => 1,
                'production_time'   => 2,
                'default_width_cm'  => 15,
                'default_height_cm' => 10,
                'allow_custom_size' => 0,
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->updateOrInsert(
                ['product_id' => $product['product_id']],
                array_merge($product, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

        $this->command->info('✅ Products selesai.');
        $this->command->info('🎉 Semua data printing berhasil dimasukkan!');
    }
}
