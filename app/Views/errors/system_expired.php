<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>System Locked</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #0f172a;
            color: #e2e8f0;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .box {
            max-width: 500px;
            padding: 40px;
            border: 1px solid #334155;
            border-radius: 12px;
            background: #111827;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 10px;
            color: #f87171;
        }

        p {
            font-size: 14px;
            color: #94a3b8;
            margin-bottom: 20px;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            background: #1f2937;
            border-radius: 8px;
            font-size: 12px;
            color: #fbbf24;
        }

        .btn {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 16px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }

        .btn:hover {
            background: #1d4ed8;
        }
    </style>
</head>

<body>

    <div class="box">
        <div class="badge">SYSTEM STATUS</div>

        <h1>System Locked</h1>

        <p>
            Akses ke aplikasi ini telah dibatasi oleh sistem otorisasi.<br>
            Silakan hubungi administrator untuk mengaktifkan kembali akses.
        </p>

        <a class="btn" href="mailto:admin@localhost">Contact Admin</a>
    </div>

</body>

</html>