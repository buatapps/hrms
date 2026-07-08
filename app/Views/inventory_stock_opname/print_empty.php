<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Print Kosong Stock Opname</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
        }

        h2,
        h4 {
            margin: 0;
            text-align: center;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #333;
            padding: 6px 8px;
        }

        .text-end {
            text-align: right;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <h2>FORM STOCK OPNAME</h2>
    <h4><?= esc($yearMonth) ?></h4>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Item</th>
                <th class="text-end">Stock Sistem</th>
                <th class="text-end">Stock Opname</th>
                <th class="text-end">Selisih</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($items as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($row->code) ?></td>
                    <td><?= esc($row->name) ?></td>
                    <td class="text-end"><?= $row->stock_akhir ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br><br>
    <div style="width: 100%; display: flex; justify-content: space-between;">
        <div style="text-align: center;">
            <p>Disiapkan oleh,</p><br><br>
            <p><strong>________________________</strong></p>
        </div>
        <div style="text-align: center;">
            <p>Disetujui oleh,</p><br><br>
            <p><strong>________________________</strong></p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>