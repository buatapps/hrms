<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Print Overtime Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            padding: 40px;
            font-size: 12px;
        }

        h4 {
            text-align: center;
            margin-bottom: 30px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div><strong>Date:</strong> <?= date('d/m/Y', strtotime($header_data->date)); ?></div>

            <h4 class="m-0 text-center flex-grow-1">OVERTIME FORM</h4>

            <div class="text-end"><strong>Created By:</strong> <?= esc($header_data->username); ?></div>
        </div>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th style="width: 40px;">No</th>
                    <th>Name</th>
                    <th>Division</th>
                    <th>Plant</th>
                    <th>Group</th>
                    <th>Jobdesk</th>
                    <th class="text-end">Overtime Hours</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detail_data as $i => $row): ?>
                    <tr>
                        <td><?= $i + 1; ?></td>
                        <td><?= esc($row->name); ?></td>
                        <td><?= esc($row->division); ?></td>
                        <td><?= esc($row->plant); ?></td>
                        <td><?= esc($row->employee_group); ?></td>
                        <td><?= esc($row->jobdesk); ?></td>
                        <td class="text-end"><?= number_format($row->total_hours, 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>

</html>