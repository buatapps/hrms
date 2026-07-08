<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Stiker Kendaraan</title>
    <script>
        window.print();
    </script>
    <style>
        @media print {
            body {
                height: auto !important;
                min-height: auto !important;
                margin: 1cm;
                background: white !important;
            }

            .badge-page {
                page-break-after: always;
            }
        }

        body {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            align-items: flex-start;
            margin: 10px;
            background: #fff;
        }

        .circle-outer {
            position: relative;
            width: 7cm;
            height: 7cm;
            border: 0.2cm solid #0c0000;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 10px;
            box-sizing: border-box;
        }

        .circle-middle {
            width: calc(7cm - 2 * 0.2cm);
            height: calc(7cm - 2 * 0.2cm);
            border: 0.2cm solid #61e3e5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .circle-inner {
            position: relative;
            width: calc(7cm - 4 * 0.2cm + 0.18cm);
            height: calc(7cm - 4 * 0.2cm + 0.18cm);
            border: 0.18cm solid #3db1fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .circle-white {
            position: relative;
            width: calc(7cm - 4 * 0.2cm - 2 * 0.18cm);
            height: calc(7cm - 4 * 0.2cm - 2 * 0.18cm);
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: visible;
        }

        .circle-white svg {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        text {
            fill: #163B65;
            font-size: 6.5pt;
            font-family: Arial, sans-serif;
            font-weight: bold;
        }

        /* Setengah lingkaran biru */
        .half-circle-blue {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 60%;
            background: #38B6FF;
            border-bottom-left-radius: 70% 100%;
            border-bottom-right-radius: 70% 100%;
            clip-path: polygon(0 40%, 100% 40%, 100% 80%, 0 80%);
            z-index: 10;

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            font-family: Arial, sans-serif;
            font-weight: bold;
            padding-top: 20px;
            user-select: none;
            text-transform: uppercase;
            letter-spacing: 2px;
            box-sizing: border-box;
        }

        .half-circle-blue .namicoh {
            /* font-size: 9pt; */
            font-size: 24pt;
            /* padding-top: 5px; */
            line-height: 1;
            font-weight: bold;
        }

        .half-circle-blue .safety-riding {
            font-size: 10pt;
            padding-top: 2px;
            line-height: 1;
        }

        .plate-text {
            position: absolute;
            bottom: 5px;
            width: 100%;
            text-align: center;
            font-family: Arial, sans-serif;
            font-weight: bold;
            font-size: 10pt;
            color: #163B65;
            user-select: none;
        }

        .qr-code {
            position: absolute;
            bottom: 35%;
            left: 50%;
            transform: translateX(-50%);
            width: 50%;
            height: auto;
        }
    </style>
</head>

<body>
    <?php
    $counter = 0;
    foreach ($employees as $emp):
        if ($counter % 6 == 0 && $counter != 0): ?>
            <div class="badge-page" style="page-break-after: always;"></div>
        <?php endif; ?>
        <div class="circle-outer">
            <div class="circle-middle">
                <div class="circle-inner">
                    <div class="circle-white">
                        <svg viewBox="0 0 100 100">
                            <defs>
                                <path id="textPath" d="M8,48 A38,38 0 0,1 92,48" />
                            </defs>
                            <text>
                                <textPath href="#textPath" startOffset="50%" text-anchor="middle">
                                    ALWAYS SAFE DRIVE
                                </textPath>
                            </text>
                        </svg>

                        <div class="half-circle-blue">
                            <div class="namicoh">NAMICOH</div>
                            <div class="safety-riding">Safety Riding</div>
                        </div>


                        <img src="<?= render_qrcode($emp['employee_id'] . '.' . $emp['name'] . '.' . $emp['division'] . '.' . $emp['nomor_plat']); ?>" alt="QR Code" class="qr-code" />

                        <div class="plate-text"><?= esc($emp['nomor_plat']) ?></div>
                    </div>
                </div>
            </div>
        </div>
    <?php
        $counter++;
    endforeach; ?>
</body>

</html>