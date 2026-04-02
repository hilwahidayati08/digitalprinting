<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Admin - Digital Printing')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Vite CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        body {
            background-color: #f0f6ff;
            background-image:
                radial-gradient(circle at 20% 20%, rgba(37,99,235,0.07) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(59,130,246,0.05) 0%, transparent 50%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 440px;
            animation: fadeUp 0.5s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .auth-card {
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow:
                0 0 0 1px rgba(0,0,0,0.06),
                0 4px 6px rgba(0,0,0,0.04),
                0 24px 48px rgba(0,0,0,0.08);
        }

        .auth-card-header {
            height: 4px;
            background: linear-gradient(90deg, #2563eb, #1d4ed8, #3b82f6);
        }

        .auth-card-body {
            padding: 44px 40px;
        }

        /* Logo */
        .auth-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 32px;
        }

        .auth-logo-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(99,102,241,0.3);
        }

        .auth-logo-text {
            font-size: 20px;
            font-weight: 800;
            color: #111;
            letter-spacing: -0.5px;
        }

        .auth-logo-sub {
            font-size: 10px;
            font-weight: 600;
            color: #aaa;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            display: block;
            line-height: 1;
        }

        /* Heading */
        .auth-heading {
            font-size: 26px;
            font-weight: 800;
            color: #0f0f0f;
            margin-bottom: 6px;
            letter-spacing: -0.5px;
            text-align: center;
        }

        .auth-subheading {
            font-size: 14px;
            color: #9ca3af;
            text-align: center;
            margin-bottom: 32px;
            font-weight: 400;
            line-height: 1.5;
        }

        /* Alert */
        .alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 13px 15px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 500;
            margin-bottom: 20px;
            animation: slideDown 0.25s ease;
        }

        @keyframes slideDown {
            from { opacity:0; transform:translateY(-6px); }
            to   { opacity:1; transform:translateY(0); }
        }

        .alert-success { background:#f0fdf4; color:#166534; border:1px solid #bbf7d0; }
        .alert-error   { background:#fef2f2; color:#991b1b; border:1px solid #fecaca; }

        /* Form */
        .form-group { margin-bottom: 18px; }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 7px;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #d1d5db;
            pointer-events: none;
            transition: color 0.15s;
        }

        .input-wrap:focus-within .input-icon { color: #2563eb; }

        .form-input {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #111;
            background: #fafafa;
            outline: none;
            transition: all 0.15s;
            box-sizing: border-box;
        }

        .form-input:focus {
            border-color: #2563eb;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }

        .form-input.is-error { border-color: #f87171; }
        .form-input::placeholder { color: #c4c4c4; }

        .form-error {
            font-size: 12px;
            color: #ef4444;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Checkbox row */
        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 13px;
            color: #555;
            cursor: pointer;
        }

        .form-check input[type="checkbox"] {
            accent-color: #2563eb;
            width: 15px;
            height: 15px;
            border-radius: 4px;
        }

        /* Button */
        .btn-primary {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            letter-spacing: 0.1px;
            box-shadow: 0 4px 12px rgba(37,99,235,0.25);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(37,99,235,0.35);
        }

        .btn-primary:active { transform: translateY(0); }

        .btn-primary svg { transition: transform 0.2s; }
        .btn-primary:hover svg { transform: translateX(3px); }

        /* Google */
        .btn-google {
            width: 100%;
            padding: 12px;
            background: #fff;
            color: #374151;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: all 0.15s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-google:hover {
            background: #f9fafb;
            border-color: #d1d5db;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 22px 0;
        }

        .divider-line { flex:1; height:1px; background:#f0f0f0; }

        .divider-text {
            font-size: 11px;
            font-weight: 600;
            color: #c4c4c4;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        /* Info box */
        .info-box {
            background: #eff6ff;
            border: 1px solid #dbeafe;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 22px;
        }

        .info-box-title {
            font-size: 13px;
            font-weight: 600;
            color: #1d4ed8;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .info-box ul {
            list-style: none;
            margin: 0; padding: 0;
        }

        .info-box ul li {
            font-size: 12.5px;
            color: #6b7280;
            padding: 3px 0;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .info-box ul li::before {
            content: '';
            width: 5px; height: 5px;
            border-radius: 50%;
            background: #93c5fd;
            flex-shrink: 0;
        }

        /* OTP Input */
        .otp-input {
            text-align: center;
            font-size: 30px;
            letter-spacing: 14px;
            font-weight: 800;
            padding-left: 28px;
            color: #111;
        }

        /* Timer */
        .timer-wrap {
            background: #eff6ff;
            border: 1px solid #dbeafe;
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 20px;
        }

        .timer-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .timer-label { font-size: 13px; font-weight: 500; color: #6b7280; }

        .timer-count {
            font-size: 20px;
            font-weight: 800;
            color: #2563eb;
            font-variant-numeric: tabular-nums;
            letter-spacing: -0.5px;
        }

        .timer-bar-bg {
            height: 4px;
            background: #dbeafe;
            border-radius: 99px;
            overflow: hidden;
        }

        .timer-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #2563eb, #3b82f6);
            border-radius: 99px;
            transition: width 1s linear;
        }

        /* Strength bars */
        .strength-row {
            display: flex;
            gap: 5px;
            margin-top: 8px;
        }

        .strength-seg {
            flex: 1;
            height: 3px;
            border-radius: 99px;
            background: #f0f0f0;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            border-radius: 99px;
            width: 0%;
            transition: width 0.3s ease, background 0.3s ease;
        }

        .strength-label {
            font-size: 12px;
            color: #aaa;
            margin-top: 5px;
        }

        /* Password checks */
        .pass-checks {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            margin-top: 8px;
        }

        .pass-check {
            font-size: 12px;
            color: #c4c4c4;
            display: flex;
            align-items: center;
            gap: 4px;
            transition: color 0.2s;
        }

        .pass-check.ok { color: #22c55e; }

        /* Auth footer */
        .auth-footer {
            text-align: center;
            margin-top: 26px;
            padding-top: 22px;
            border-top: 1px solid #f3f4f6;
            font-size: 13.5px;
            color: #9ca3af;
        }

        .auth-link {
            color: #2563eb;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.15s;
        }

        .auth-link:hover { color: #4f46e5; text-decoration: underline; }

        /* Back link */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 500;
            color: #9ca3af;
            text-decoration: none;
            margin-bottom: 28px;
            transition: color 0.15s;
        }

        .back-link:hover { color: #2563eb; }
        .back-link svg { transition: transform 0.15s; }
        .back-link:hover svg { transform: translateX(-2px); }

        /* Page footer */
        .page-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #d1d5db;
        }

        /* Security badge */
        .security-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-top: 18px;
            padding-top: 18px;
            border-top: 1px solid #f3f4f6;
        }

        .badge-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            color: #d1d5db;
            font-weight: 500;
        }

        .badge-item svg { color: #a3e635; }
    </style>

    @stack('styles')
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-card-header"></div>
            <div class="auth-card-body">
                @yield('content')
            </div>
        </div>
        <div class="page-footer">&copy; {{ date('Y') }} Digital Printing. All rights reserved.</div>
    </div>

    @stack('scripts')
</body>
</html>