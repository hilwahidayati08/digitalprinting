<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faqs;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        Faqs::insert([
            [
                'question' => 'Berapa lama proses pengerjaan cetak?',
                'answer' => 'Proses pengerjaan biasanya memakan waktu 1-3 hari kerja tergantung jenis produk dan jumlah pesanan.',
                'is_active' => 1
            ],
            [
                'question' => 'Apakah bisa cetak dalam jumlah kecil?',
                'answer' => 'Ya, kami melayani cetak satuan maupun dalam jumlah besar sesuai kebutuhan Anda.',
                'is_active' => 1
            ],
            [
                'question' => 'Bagaimana cara melakukan pemesanan?',
                'answer' => 'Anda bisa melakukan pemesanan melalui website kami atau langsung menghubungi admin melalui WhatsApp.',
                'is_active' => 1
            ],
            [
                'question' => 'Apakah bisa desain custom?',
                'answer' => 'Tentu, kami menyediakan layanan desain custom sesuai dengan kebutuhan dan konsep yang Anda inginkan.',
                'is_active' => 1
            ],
            [
                'question' => 'Metode pembayaran apa saja yang tersedia?',
                'answer' => 'Kami menerima transfer bank dan pembayaran digital melalui Midtrans.',
                'is_active' => 1
            ],
            [
                'question' => 'Apakah ada garansi hasil cetak?',
                'answer' => 'Ya, kami memberikan garansi jika hasil cetak tidak sesuai dengan pesanan yang telah disepakati.',
                'is_active' => 1
            ],
        ]);
    }
}