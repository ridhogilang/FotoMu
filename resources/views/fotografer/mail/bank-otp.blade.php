<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verifikasi Penambahan Rekening</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #04ABC1;
            color: white;
            text-align: center;
            padding: 20px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1, h2, h3 {
            margin: 0;
        }

        .otp-code {
            background-color: #e6f7f9;
            color: #04ABC1;
            font-size: 28px;
            font-weight: bold;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            margin: 20px 0;
            letter-spacing: 2px;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            color: #333333;
        }

        .note {
            font-size: 14px;
            color: #888888;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #888888;
        }

        .footer a {
            color: #04ABC1;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>OTP Verifikasi Penambahan Rekening</h1>
        </div>
        <div>
            <p><strong>Kode OTP untuk Verifikasi Penambahan Rekening</strong></p>
            <p>Silakan gunakan kode OTP berikut untuk memverifikasi penambahan rekening Anda:</p>
            <div class="otp-code">{{ $details['otp'] }}</div>
            <p><strong>Catatan:</strong> Jangan berikan kode ini kepada siapapun. Kode OTP ini berlaku selama 10 menit.</p>
        </div>
        <div class="footer">
            <p>Terima kasih telah menggunakan layanan kami.<br>Jika Anda memerlukan bantuan, hubungi <a href="mailto:support@fotomu.my.id">support@fotomu.my.id</a>.</p>
        </div>
    </div>
</body>

</html>
