<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password OTP</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f4f4f7;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            color: white;
            font-size: 28px;
            font-weight: bold;
        }
        .content {
            padding: 40px 30px;
            text-align: center;
        }
        .content h2 {
            color: #333;
            margin-bottom: 10px;
        }
        .otp-box {
            background-color: #f8f9fa;
            border: 3px dashed #4F46E5;
            border-radius: 16px;
            padding: 30px;
            margin: 25px 0;
            text-align: center;
        }
        .otp-code {
            font-size: 48px;
            font-weight: 800;
            letter-spacing: 8px;
            color: #4F46E5;
            font-family: 'Courier New', monospace;
        }
        .expiry {
            background-color: #FEE2E2;
            color: #DC2626;
            padding: 12px;
            border-radius: 8px;
            margin: 20px 0;
            font-weight: 600;
        }
        .warning {
            background-color: #FEF3C7;
            border-left: 4px solid #F59E0B;
            padding: 15px;
            margin: 25px 0;
            text-align: left;
            border-radius: 6px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔐 Digital Printing</h1>
        </div>
        
        <div class="content">
            <h2>Halo, {{ $username }}!</h2>
            <p style="color: #666; margin-bottom: 20px;">
                Kami menerima permintaan reset password untuk akun Digital Printing Anda.
            </p>
            
            <div class="otp-box">
                <div style="margin-bottom: 15px; color: #666; font-weight: 600;">Kode OTP Anda:</div>
                <div class="otp-code">{{ $otpCode }}</div>
            </div>
            
            <div class="expiry">
                ⏰ Kode berlaku selama 15 menit
            </div>
            
            <div class="warning">
                <strong>⚠️ PERHATIAN:</strong>
                <p style="margin: 5px 0 0 0; font-size: 14px; color: #92400E;">
                    Jangan berikan kode ini kepada siapapun, termasuk pihak yang mengaku dari Digital Printing. 
                    Kami tidak akan pernah meminta kode OTP Anda.
                </p>
            </div>
            
            <p style="color: #666; margin-top: 30px; font-size: 14px;">
                Jika Anda tidak merasa melakukan permintaan reset password, 
                abaikan email ini dan pastikan akun Anda tetap aman.
            </p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Digital Printing. Seluruh hak cipta dilindungi.</p>
            <p style="margin-top: 10px; font-size: 12px; color: #999;">
                Email ini dikirim secara otomatis, mohon tidak membalas email ini.
            </p>
        </div>
    </div>
</body>
</html>