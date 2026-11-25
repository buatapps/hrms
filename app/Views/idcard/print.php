<?php
$namaPerusahaan = 'PT.NAMICOH INDONESIA COMPONENT';
$logoUtama      = base_url('assets/images/logo-namicoh.png');
$logoFallback   = base_url('assets/images/logo.png');
$mirror         = !empty($mirror);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 20px 0;
            background: #f4f6f8;
            font-family: Arial, Helvetica, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        body.mirror .id-card {
            transform: scaleX(-1);
            -webkit-transform: scaleX(-1);
            transform-origin: center;
        }

        .print-sheet {
            position: relative;
            width: 210mm;
            height: 297mm;
            padding: 10mm;
            background: #ffffff;
            display: grid;
            grid-template-columns: repeat(3, 54mm);
            grid-template-rows: repeat(3, 86mm);
            column-gap: 14mm;
            row-gap: 9.5mm;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.18);
            page-break-after: always;
            break-after: page;
        }

        .print-sheet:last-child {
            page-break-after: auto;
            break-after: auto;
        }

        .card-wrap {
            width: 54mm;
            height: 86mm;
        }

        .id-card {
            position: relative;
            width: 54mm;
            height: 86mm;
            background-color: #EBF9FF;
            border-radius: 3mm;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            padding: 3.5mm 3mm 12mm;
            text-align: center;
        }

        .konten-utama {
            position: relative;
            z-index: 1;
        }

        .logo-perusahaan img {
            width: 10mm;
            height: auto;
            display: block;
            margin: 0 auto 1mm;
        }

        .nama-brand {
            font-size: 9pt;
            font-weight: 800;
            color: #0b3c6d;
            margin: 0 0 1.5mm;
            line-height: 1.1;
        }

        .nama-perusahaan {
            font-size: 5.5pt;
            font-weight: 800;
            color: #111111;
            letter-spacing: 0.1mm;
            margin: 0 0 3mm;
            line-height: 1.2;
        }

        .foto-karyawan {
            position: relative;
            width: 22mm;
            height: 27.5mm;
            margin: 0 auto 2.5mm;
            border-radius: 2mm;
            border: 0.6mm solid #1d4ed8;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #d9eaf7;
        }

        .foto-karyawan img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .foto-placeholder {
            font-size: 18pt;
            font-weight: 800;
            color: #0b3c6d;
        }

        .nama-karyawan {
            font-size: 6.8pt;
            font-weight: 800;
            color: #111111;
            margin: 0 0 2.5mm;
            line-height: 1.2;
        }

        .bagian-bawah {
            display: flex;
            align-items: stretch;
            justify-content: center;
            gap: 1mm;
            width: 100%;
            text-align: center;
        }

        .qr-code {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qr-code img {
            width: auto;
            height: 100%;
            max-width: 10mm;
            max-height: 10mm;
            aspect-ratio: 1 / 1;
            display: block;
            background: #ffffff;
            padding: 0;
            box-sizing: border-box;
        }

        .info-karyawan {
            width: max-content;
            max-width: 100%;
            min-width: 0;
            text-align: center;
        }

        .info-karyawan p {
            margin: 0.15mm 0;
            font-size: 6pt;
            font-weight: 800;
            color: #111111;
            line-height: 1.15;
            word-break: break-word;
        }

        .dekorasi-bawah {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: auto;
            display: block;
            z-index: 0;
            pointer-events: none;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 0;
            }

            body {
                margin: 0;
                padding: 0;
                background: none;
                display: block;
            }

            body.mirror .id-card {
                transform: scaleX(-1);
                -webkit-transform: scaleX(-1);
                transform-origin: center;
            }

            .print-sheet {
                margin: 0;
                box-shadow: none;
            }

            .card-wrap {
                page-break-inside: avoid;
                break-inside: avoid;
            }

            .id-card {
                box-shadow: none;
                border-radius: 0;
            }
        }
    </style>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</head>

<body class="<?= $mirror ? 'mirror' : ''; ?>">
    <?php foreach (array_chunk($employees, 9) as $sheet): ?>
        <div class="print-sheet">
            <?php foreach ($sheet as $employee): ?>
                <?php
                $words    = preg_split('/\s+/', trim($employee['name']));
                $initials = strtoupper(substr($words[0] ?? '?', 0, 1) . substr($words[1] ?? '', 0, 1));
                $foto     = !empty($employee['picture']) ? base_url('employee_picture/' . $employee['picture']) : '';
                $qrData   = implode('.', [
                    $employee['employee_id'],
                    $employee['name'],
                    $employee['division'],
                    $employee['position'] ?? '-',
                ]);
                ?>
                <div class="card-wrap">
                    <div class="id-card">
                        <div class="konten-utama">
                            <div class="logo-perusahaan">
                                <img src="<?= esc($logoUtama) ?>" alt="Logo Namicoh" onerror="this.onerror=null;this.src='<?= $logoFallback ?>';">
                            </div>

                            <p class="nama-brand">Namicoh</p>

                            <h1 class="nama-perusahaan"><?= esc($namaPerusahaan) ?></h1>

                            <div class="foto-karyawan">
                                <span class="foto-placeholder"><?= esc($initials) ?></span>
                                <?php if ($foto !== ''): ?>
                                    <img src="<?= esc($foto) ?>" alt="Foto <?= esc($employee['name']) ?>" onerror="this.style.display='none';">
                                <?php endif; ?>
                            </div>

                            <h2 class="nama-karyawan"><?= esc($employee['name']) ?></h2>

                            <div class="bagian-bawah">
                                <div class="qr-code">
                                    <img src="<?= render_qrcode($qrData) ?>" alt="QR Code <?= esc($employee['employee_id']) ?>">
                                </div>
                                <div class="info-karyawan">
                                    <p><?= esc($employee['position'] ?? '-') ?></p>
                                    <p><?= esc($employee['division'] ?? '-') ?></p>
                                    <p><?= esc($employee['employee_id']) ?></p>
                                </div>
                            </div>
                        </div>

                        <img class="dekorasi-bawah" src="<?= esc(base_url('assets/images/id-card-bawah.png')) ?>" alt="">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</body>

</html>
