<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Reset Kata Sandi | Equiply</title>
</head>

<body style="font-family: Poppins, sans-serif; background:#f3f4f6; padding:20px;">
    <div
        style="max-width:600px; margin:auto; background:white; border-radius:10px; padding:30px; box-shadow:0 2px 10px rgba(0,0,0,0.1); text-align:center;">
        <!-- Logo -->
        <div style="margin-bottom:20px;">
           <img src="https://i.imgur.com/QWfytbi.png" alt="Equiply" style="height:50px;">
        </div>

        <!-- Header -->
        <h2 style="color:#111827;">Reset Kata Sandi</h2>
        <p style="color:#374151;">Kami menerima permintaan reset kata sandi untuk akun Anda.</p>

        <!-- Tombol Reset -->
        <div style="margin:30px 0;">
            <a href="{{ $url }}"
                style="
                background:#2563EB;
                color:white;
                padding:12px 25px;
                border-radius:8px;
                text-decoration:none;
                display:inline-block;
                font-weight:bold;
            ">
                Reset Kata Sandi
            </a>
        </div>

        <p style="color:#6B7280; font-size:14px;">
            Tautan ini akan kadaluarsa dalam 60 menit.<br>
            Jika Anda tidak meminta reset kata sandi, abaikan email ini.
        </p>

        <!-- Footer -->
        <p style="color:#9CA3AF; font-size:12px; margin-top:20px;">
            © {{ date('Y') }} Equiply — Sistem Peminjaman Alat<br>
            Email ini dikirim otomatis, mohon tidak membalas.
        </p>
    </div>
</body>

</html>
