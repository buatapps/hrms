<?php
$nama_perusahaan = 'PT.NAMICOH INDONESIA COMPONENT';
$judul_aturan    = 'TERMS & CONDITIONS';

$aturan_list = [
    [
        'judul' => 'Identitas:',
        'isi'   => 'Wajib digunakan selama jam kerja sebagai tanda pengenal resmi perusahaan.'
    ],
    [
        'judul' => 'Akses Kantin:',
        'isi'   => 'Berlaku untuk pemindaian (scan) pengambilan jatah makan di kantin (maksimal 1 kali per shift).'
    ],
    [
        'judul' => 'Penggunaan Resmi:',
        'isi'   => 'Bersifat pribadi dan dilarang dipinjamkan atau disalahgunakan oleh pihak lain.'
    ],
    [
        'judul' => 'Kehilangan/Kerusakan:',
        'isi'   => 'Apabila tanda pengenal ini rusak atau hilang, karyawan yang bersangkutan dikenakan denda Rp 50.000'
    ]
];

$alamat_baris_2 = 'Cikarang Selatan, Bekasi, 17550, Indonesia';
$telepon        = 'Phone : 021-897-5267';
$mirror         = !empty($mirror);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card Belakang - <?= esc($nama_perusahaan) ?></title>
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
            padding: 12mm 3.5mm 11mm;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .dekorasi-atas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: auto;
            display: block;
            z-index: 0;
            pointer-events: none;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .konten-belakang {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
            justify-content: space-between;
        }

        .header-aturan {
            text-align: center;
            margin-bottom: 1.5mm;
        }

        .nama-perusahaan {
            font-size: 5.5pt;
            font-weight: 800;
            color: #111111;
            margin: 0 0 1mm;
            line-height: 1.2;
        }

        .judul-aturan {
            font-size: 6pt;
            font-weight: 800;
            color: #111111;
            margin: 0;
            line-height: 1.2;
        }

        .daftar-aturan {
            margin: 0;
            padding-left: 3.5mm;
            color: #111111;
        }

        .daftar-aturan li {
            font-size: 6.5pt;
            line-height: 1.25;
            margin-bottom: 1.4mm;
        }

        .daftar-aturan li strong {
            font-weight: 800;
        }

        .info-alamat {
            text-align: center;
            font-size: 4.5pt;
            color: #111111;
            line-height: 1.25;
            margin-top: 1mm;
        }

        .info-alamat p {
            margin: 0.2mm 0;
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
                <div class="card-wrap">
                    <div class="id-card">
                        <img class="dekorasi-atas" src="<?= esc(base_url('assets/images/print-back-atas.png')) ?>" alt="">

                        <div class="konten-belakang">
                            <div class="header-aturan">
                                <p class="nama-perusahaan"><?= esc($nama_perusahaan) ?></p>
                                <p class="judul-aturan"><?= esc($judul_aturan) ?></p>
                            </div>

                            <ul class="daftar-aturan">
                                <?php foreach ($aturan_list as $aturan): ?>
                                    <li>
                                        <strong><?= esc($aturan['judul']) ?></strong>
                                        <?= esc($aturan['isi']) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                            <div class="info-alamat">
                                <p><strong>EJIP</strong> Industrial Park Plot 6B-1</p>
                                <p><?= esc($alamat_baris_2) ?></p>
                                <p><?= esc($telepon) ?></p>
                            </div>
                        </div>

                        <img class="dekorasi-bawah" src="<?= esc(base_url('assets/images/print-back-bawah.png')) ?>" alt="">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</body>

</html>
