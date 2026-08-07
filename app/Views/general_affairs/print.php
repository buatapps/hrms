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
            overflow: hidden;
            padding-left: 2px;
            margin-top: 1mm;
            page-break-inside: avoid;
            page-break-after: always;
        }

        .label:last-child {
            page-break-after: auto;
        }

        .vertical-divider {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 50%;
            border-left: 0.4mm solid #000;
        }

        .label-left {
            position: absolute;
            top: 3mm;
            bottom: 3mm;
            left: calc(3mm + 2px);
            right: calc(50% + 0.5mm);
            display: flex;
            flex-direction: column;
        }

        .label-right {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 50%;
            right: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .qr-box {
            margin: auto 1.5mm;
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #fff;
            border-radius: 2mm;
            padding: 0.6mm 1.5mm;
        }

        .label-right .namicoh {
            font-size: 9pt;
            letter-spacing: 1.5pt;
            color: #000;
            margin-top: 0.6mm;
        }

        .label-right .always-safe,
        .label-right .safety-riding {
            font-size: 6.5pt;
            margin-top: 0.5mm;
            margin-bottom: -0.3mm;
            line-height: 1;
            color: #000;
        }

        .qr-img {
            margin-top: 1mm;
            width: 20mm;
            height: 20mm;
            border: 0.3mm solid #000;
            padding: 0.5mm;
            background: #fff;
        }

        .label-right .plate-band {
            width: 100%;
            margin-top: 0;
            font-size: 8pt;
            letter-spacing: 1.5pt;
            padding: 0.6mm 0;
            background: transparent;
            color: #000;
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
            background: #fff;
            color: #000;
            font-size: 10pt;
            font-weight: bold;
            letter-spacing: 2pt;
            text-align: center;
            padding: 1.2mm 0;
            border-radius: 0;
        }
    </style>
</head>

<body>
    <?php if (empty($employees)): ?>
        <p style="font-family: Arial, sans-serif; margin: 20px;">Tidak ada data untuk dicetak.</p>
    <?php endif; ?>

    <?php foreach ($employees as $emp): ?>
        <div class="label">
            <div class="vertical-divider"></div>
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
            </div>
            <div class="label-right">
                <div class="qr-box">
                    <div class="namicoh">Namicoh</div>
                    <div class="always-safe">Always Safe</div>
                    <img src="<?= render_qrcode(json_encode([
                        'employee_id'        => $emp['employee_id'],
                        'name'               => $emp['name'],
                        'division'           => $emp['division'],
                        'nomor_plat'         => $emp['nomor_plat'],
                        'masa_berlaku_pajak' => $emp['masa_berlaku_pajak'],
                        'masa_berlaku_plat'  => $emp['masa_berlaku_plat'],
                        'sim_masa_berlaku'   => $emp['sim_masa_berlaku'],
                    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)); ?>" alt="QR Code" class="qr-img" />
                    <div class="safety-riding">Safety Riding</div>
                    <div class="plate-band"><?= esc($emp['nomor_plat']); ?></div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</body>

</html>
