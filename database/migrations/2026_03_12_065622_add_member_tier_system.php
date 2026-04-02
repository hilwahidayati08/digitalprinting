<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ============================================================
        // TABEL USERS
        // Sudah ada: user_id, username, useremail, password, no_telp,
        //            role, remember_token, is_member, saldo_komisi
        // Tambah   : member_tier, commission_rate_override, total_spent
        // ============================================================
        Schema::table('users', function (Blueprint $table) {
            $table->enum('member_tier', ['regular', 'plus', 'premium'])
                  ->default('regular')
                  ->after('is_member');

            $table->decimal('commission_rate_override', 5, 2)
                  ->nullable()
                  ->after('member_tier')
                  ->comment('Diisi admin untuk override rate khusus. Null = ikut rate tier di settings.');

            $table->decimal('total_spent', 15, 2)
                  ->default(0)
                  ->after('commission_rate_override')
                  ->comment('Total belanja kumulatif, untuk hitung naik tier otomatis.');
        });

        // ============================================================
        // TABEL SETTINGS
        // Sudah ada: setting_id, whatsapp, email, instagram_url,
        //            facebook_url, tiktok_url, time_open, time_close,
        //            address, member_commission_rate
        // Hapus    : member_commission_rate (diganti per tier)
        // Tambah   : member_min_orders, member_min_spent,
        //            rate_regular, rate_plus, rate_premium,
        //            tier_plus_min, tier_premium_min
        // ============================================================
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('member_commission_rate');

            $table->integer('member_min_orders')
                  ->default(5)
                  ->after('address')
                  ->comment('Minimal jumlah order untuk bisa ajukan member');

            $table->decimal('member_min_spent', 15, 2)
                  ->default(500000)
                  ->after('member_min_orders')
                  ->comment('Minimal total belanja untuk bisa ajukan member');

            $table->decimal('rate_regular', 5, 2)
                  ->default(5)
                  ->after('member_min_spent')
                  ->comment('Diskon % untuk tier Regular');

            $table->decimal('rate_plus', 5, 2)
                  ->default(10)
                  ->after('rate_regular')
                  ->comment('Diskon % untuk tier Plus');

            $table->decimal('rate_premium', 5, 2)
                  ->default(15)
                  ->after('rate_plus')
                  ->comment('Diskon % untuk tier Premium');

            $table->decimal('tier_plus_min', 15, 2)
                  ->default(1000000)
                  ->after('rate_premium')
                  ->comment('Min. total belanja kumulatif untuk naik ke tier Plus');

            $table->decimal('tier_premium_min', 15, 2)
                  ->default(5000000)
                  ->after('tier_plus_min')
                  ->comment('Min. total belanja kumulatif untuk naik ke tier Premium');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['member_tier', 'commission_rate_override', 'total_spent']);
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'member_min_orders', 'member_min_spent',
                'rate_regular', 'rate_plus', 'rate_premium',
                'tier_plus_min', 'tier_premium_min',
            ]);
            $table->decimal('member_commission_rate', 5, 2)->default(8.00);
        });
    }
};