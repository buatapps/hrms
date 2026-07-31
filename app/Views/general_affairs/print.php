<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Stiker Kendaraan</title>
    <script>
        window.addEventListener('load', function() {
            window.print();
        });
    </script>
    <style>
        @page {
            size: 80mm 40mm;
            margin: 0;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: #fff;
            font-family: Arial, sans-serif;
        }

        @media print {
            body {
                margin: 0;
                background: white !important;
            }

            #debug-icon,
            #debug-bar,
            #toolbar_js {
                display: none !important;
            }
        }

        .label {
            position: relative;
            width: 79mm;
            height: 38.5mm;
            border: 1mm solid #000;
            border-radius: 2mm;
            overflow: hidden;
            padding-left: 2px;
            margin-top: 1mm;
            page-break-inside: avoid;
            page-break-after: always;
        }

        .label:last-child {
            page-break-after: auto;
        }

        .label-left {
            position: absolute;
            top: 3mm;
            bottom: 3mm;
            left: calc(3mm + 2px);
            right: 40mm;
            display: flex;
            flex-direction: column;
        }

        .namicoh {
            font-size: 11pt;
            font-weight: bold;
            letter-spacing: 2pt;
            text-transform: uppercase;
            line-height: 1;
            color: #000;
        }

        .safety-riding {
            font-size: 4.5pt;
            line-height: 1.4;
            margin-top: 0.8mm;
            color: #000;
        }

        .divider {
            border-top: 0.4mm solid #000;
            margin: 1.2mm 0;
        }

        .info-row {
            font-size: 5pt;
            line-height: 1.4;
            color: #000;
            text-transform: uppercase;
        }

        .info-row .lbl {
            font-weight: bold;
        }

        .info-row .val {
            font-weight: normal;
        }

        .spacer {
            flex: 1;
        }

        .plate-band {
            background: #000;
            color: #fff;
            font-size: 10pt;
            font-weight: bold;
            letter-spacing: 2pt;
            text-align: center;
            padding: 1.2mm 0;
            border-radius: 1mm;
        }

        .qr-img {
            position: absolute;
            top: calc(1mm + 5px);
            right: calc(1mm + 5px);
            width: 33mm;
            height: 33mm;
        }
    </style>
</head>

<body>
    <?php if (empty($employees)): ?>
        <p style="font-family: Arial, sans-serif; margin: 20px;">Tidak ada data untuk dicetak.</p>
    <?php endif; ?>

    <?php foreach ($employees as $emp): ?>
        <div class="label">
            <div class="label-left">
                <div class="namicoh">Namicoh</div>
                <div class="safety-riding">Safety Riding</div>
                <div class="divider"></div>
                <div class="info-row"><span class="lbl">Nama : </span><span class="val"><?= esc($emp['name']); ?></span></div>
                <div class="info-row"><span class="lbl">NIK : </span><span class="val"><?= esc($emp['employee_id']); ?></span></div>
                <div class="info-row"><span class="lbl">Kend : </span><span class="val"><?= esc($emp['kendaraan'] . ' ' . $emp['brand'] . ' ' . $emp['tipe_kendaraan']); ?></span></div>
                <div class="info-row"><span class="lbl">STNK Berlaku : </span><span class="val"><?= esc($emp['masa_berlaku_pajak']); ?></span></div>
                <div class="info-row"><span class="lbl">Plat Berlaku : </span><span class="val"><?= esc($emp['masa_berlaku_plat']); ?></span></div>
                <div class="info-row"><span class="lbl">SIM Berlaku : </span><span class="val"><?= esc($emp['sim_masa_berlaku']); ?></span></div>
                <div class="divider"></div>
                <div class="spacer"></div>
                <div class="plate-band"><?= esc($emp['nomor_plat']); ?></div>
            </div>
            <img src="<?= render_qrcode(json_encode([
                'employee_id'        => $emp['employee_id'],
                'name'               => $emp['name'],
                'division'           => $emp['division'],
                'nomor_plat'         => $emp['nomor_plat'],
                'masa_berlaku_pajak' => $emp['masa_berlaku_pajak'],
                'masa_berlaku_plat'  => $emp['masa_berlaku_plat'],
                'sim_masa_berlaku'   => $emp['sim_masa_berlaku'],
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)); ?>" alt="QR Code" class="qr-img" />
        </div>
    <?php endforeach; ?>
</body>

</html>
