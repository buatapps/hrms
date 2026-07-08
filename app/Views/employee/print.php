<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Print Kartu Karyawan</title>
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .page {
                page-break-after: always;
            }

            .page:last-child {
                page-break-after: auto;
            }
        }

        body {
            font-family: Arial, sans-serif;
            padding: 10px;
        }

        .page {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: flex-start;
        }

        .card-container {
            width: 9cm;
            height: 4cm;
            border: 1px solid #333;
            background-color: #fff;
            box-sizing: border-box;
            padding: 5px 5px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin-top: 4px;
        }

        .card-body {
            display: flex;
            align-items: center;
            flex-grow: 1;
        }

        .qr {
            width: 3cm;
            height: 3cm;
        }

        .info {
            flex-grow: 1;
            margin-left: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .name {
            font-size: 16pt;
            font-weight: bold;
        }

        .employee-id {
            font-size: 12pt;
            margin-top: 4px;
        }

        .qr img {
            width: 100%;
            height: 100%;
            object-fit: fill;
            display: block;
        }
    </style>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</head>

<body>
    <?php
    $chunked = array_chunk($employees, 12); // pecah jadi per 12 kartu per halaman
    foreach ($chunked as $pageEmployees): ?>
        <div class="page">
            <?php foreach ($pageEmployees as $employee): ?>
                <div class="card-container">
                    <div class="card-body">
                        <div class="qr">
                            <img src="<?= render_qrcode($employee['employee_id'] . '.' . $employee['name'] . '.' . $employee['division']); ?>" alt="QR Code" />
                        </div>
                        <div class="info">
                            <div class="name"><?= shortenName(esc($employee['name'])) ?></div>
                            <div class="employee-id"><?= esc($employee['employee_id']) ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</body>

</html>