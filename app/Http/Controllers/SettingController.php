<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Settings::first() ?? new Settings();
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'whatsapp'          => 'nullable|string|max:20',
            'email'             => 'nullable|email',
            'instagram_url'     => 'nullable|url',
            'facebook_url'      => 'nullable|url',
            'tiktok_url'        => 'nullable|url',
            'time_open'         => 'nullable|date_format:H:i',
            'time_close'        => 'nullable|date_format:H:i',
            'address'           => 'nullable|string',

            // Syarat pengajuan member
            'member_min_orders' => 'nullable|integer|min:1',
            'member_min_spent'  => 'nullable|numeric|min:0',

            // Rate per tier
            'rate_regular'      => 'nullable|numeric|min:0|max:100',
            'rate_plus'         => 'nullable|numeric|min:0|max:100',
            'rate_premium'      => 'nullable|numeric|min:0|max:100',

            // Batas naik tier
            'tier_plus_min'     => 'nullable|numeric|min:0',
            'tier_premium_min'  => 'nullable|numeric|min:0',
        ]);

        $settings = Settings::first();

        if ($settings) {
            $settings->update($request->all());
        } else {
            Settings::create($request->all());
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}