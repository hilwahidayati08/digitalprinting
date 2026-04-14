<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - Digital Printing')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">

    <style>
        /* Base Setup */
        * { box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body {
            background-color: #f8faff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden; /* No Scroll */
        }

        /* Container & Card */
        .auth-wrapper {
            width: 95%;
            max-width: 720px; /* Ukuran Compact */
            animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .auth-card {
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.06);
            display: flex;
            width: 100%;
            min-height: 460px; /* Tinggi Pendek */
        }

        /* Panel Kiri */
        .auth-left { flex: 1; padding: 30px 40px; background: white; z-index: 2; }
        
        /* Panel Biru + Animasi Gradient */
        .auth-right {
            flex: 0.8;
            background: linear-gradient(-45deg, #1e40af, #2563eb, #3b82f6, #1d4ed8);
            background-size: 400% 400%;
            animation: gradientBG 10s ease infinite;
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            position: relative;
        }
        @@keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Animasi Ikon Melayang */
        .floating-icon {
            animation: floating 3s ease-in-out infinite;
            font-size: 45px;
            margin-bottom: 15px;
            display: inline-block;
        }
        @@keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }

        /* Efek Kursor Mengetik */
        .typing-text::after {
            content: "|";
            animation: blink 1s infinite;
            margin-left: 5px;
            color: #60a5fa;
        }
        @@keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0; } }

        /* Form Elements */
        .auth-brand { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; }
        .auth-brand-icon { background: #2563eb; padding: 6px; border-radius: 8px; color: white; font-size: 14px; }
        .auth-brand-name { font-size: 15px; font-weight: 800; color: #1e293b; }
        .auth-title { font-size: 20px; font-weight: 800; color: #1e293b; margin: 0; }
        .auth-subtitle { color: #64748b; margin-bottom: 20px; font-size: 13px; }
        .auth-field { margin-bottom: 12px; }
        .auth-label { display: block; font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 4px; text-transform: uppercase; }
        .auth-input-wrap { position: relative; }
        .auth-input-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #cbd5e1; font-size: 13px; }
        .auth-input {
            width: 100%; padding: 9px 12px 9px 38px; border: 1.5px solid #eef2f6;
            border-radius: 10px; font-size: 13px; transition: 0.3s; background: #f8fafc;
        }
        .auth-input:focus { outline: none; border-color: #2563eb; background: white; }
        .auth-btn-primary {
            width: 100%; padding: 10px; background: #2563eb; color: white; border: none;
            border-radius: 10px; font-weight: 700; cursor: pointer; font-size: 13px; transition: 0.3s;
        }
        .auth-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 5px 15px rgba(37,99,235,0.2); }
        
        .auth-divider { display: flex; align-items: center; gap: 10px; margin: 12px 0; color: #cbd5e1; font-size: 11px; }
        .auth-divider-line { flex: 1; height: 1px; background: #eef2f6; }
        
        .auth-btn-google {
            width: 100%; padding: 9px; background: white; border: 1.5px solid #eef2f6;
            border-radius: 10px; font-weight: 600; display: flex; align-items: center; 
            justify-content: center; gap: 8px; color: #475569; text-decoration: none; font-size: 12px;
            position: relative; z-index: 10;
        }

        /* Footer Rapih */
        .page-footer {
            margin-top: 15px;
            font-size: 11px;
            color: #94a3b8;
            text-align: center;
        }
        .page-footer b { color: #2563eb; }

        @@keyframes fadeUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }

        @@media (max-width: 768px) { .auth-right { display: none; } .auth-wrapper { max-width: 360px; } }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            @yield('content')
        </div>
        <div class="page-footer">
            &copy; 2026 <b>Digital Printing</b>. All rights reserved.
        </div>
    </div>
    @stack('scripts')
</body>
</html>