<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Print Stock Opname</title>
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
            text-align: left;
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
    <h2>STOCK OPNAME</h2>
    <h4><?= esc($header->year_month) ?></h4>

    <p><strong>Dibuat oleh:</strong> <?= esc($header->created_by_name ?? '-') ?> |
        <strong>Dibuat tanggal:</strong> <?= date('d-m-Y H:i', strtotime($header->created_at)) ?>
    </p>

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
            foreach ($list_data as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($row->item_code) ?></td>
                    <td><?= esc($row->item_name) ?></td>
                    <td class="text-end"><?= $row->stock_akhir ?></td>
                    <td class="text-end"><?= $row->stock_opname ?></td>
                    <td class="text-end"><?= $row->selisih ?></td>
                    <td><?= esc($row->keterangan) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br><br>
    <div style="width: 100%; display: flex; justify-content: space-between;">
        <div style="text-align: center;">
            <p>Disiapkan oleh,</p><br><br>
            <p><strong><?= esc($header->created_by_name ?? '_________________') ?></strong></p>
        </div>
        <div style="text-align: center;">
            <p>Disetujui oleh,</p><br><br>
            <p><strong>_______________________</strong></p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>