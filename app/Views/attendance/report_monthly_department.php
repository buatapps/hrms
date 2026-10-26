<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
<style>
    .filter-scroll {
        overflow-x: auto;
        width: 100%;
    }

    .card-body {
        overflow-x: hidden;
        /* MATIKAN scroll di sini */
    }

    .dt-responsive {
        overflow-x: visible !important;
    }

    table {
        white-space: nowrap;
        width: max-content;
        min-width: 100%;
    }
</style>
<!-- Start Content-->
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active"><?= $title; ?></li>
                    </ol>
                </div>
                <h4 class="page-title"><?= $title; ?></h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="<?= base_url('attendance/searchreportmonyhlydepartment'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="row">

                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Start Date</label>
                                    <input
                                        type="date"
                                        name="start_date"
                                        class="form-control"
                                        value="<?= esc($start_date) ?>">
                                </div>
                            </div>

                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">End Date</label>
                                    <input
                                        type="date"
                                        name="end_date"
                                        class="form-control"
                                        value="<?= esc($end_date) ?>">
                                </div>
                            </div>

                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Division</label>
                                    <select name="division_id" class="form-control select2">
                                        <option value="">-- All --</option>
                                        <?php if (!empty($division)): ?>
                                            <?php foreach ($division as $row): ?>
                                                <?php if ($row): ?>
                                                    <option value="<?= $row->id ?>" <?= ($row->id == $division_id) ? 'selected' : '' ?>>
                                                        <?= $row->name ?>
                                                    </option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Plant</label>
                                    <select name="plant_id" class="form-control select2">
                                        <option value="">-- All --</option>
                                        <?php if (!empty($plant)): ?>
                                            <?php foreach ($plant as $row): ?>
                                                <?php if ($row): ?>
                                                    <option value="<?= $row->id ?>" <?= ($row->id == $plant_id) ? 'selected' : '' ?>>
                                                        <?= $row->name ?>
                                                    </option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Group</label>
                                    <select name="employee_group_id" class="form-control select2">
                                        <option value="">-- All --</option>
                                        <?php if (!empty($group)): ?>
                                            <?php foreach ($group as $row): ?>
                                                <?php if ($row): ?>
                                                    <option value="<?= $row->id ?>" <?= ($row->id == $employee_group_id) ? 'selected' : '' ?>>
                                                        <?= $row->name ?>
                                                    </option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php if ($showData): ?>
    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-light py-2 mb-3">
                        <strong>Periode:</strong> <?= esc($periode_label) ?>
                    </div>
                    <!-- <form action="<?= base_url('attendance/export_report_monthly_department'); ?>" method="post" class="d-inline">
                        <?= csrf_field(); ?>

                        <input type="hidden" name="start_date" value="<?= esc($start_date) ?>">
                        <input type="hidden" name="end_date" value="<?= esc($end_date) ?>">
                        <input type="hidden" name="division_id" value="<?= esc($division_id) ?>">
                        <input type="hidden" name="plant_id" value="<?= esc($plant_id) ?>">
                        <input type="hidden" name="employee_group_id" value="<?= esc($employee_group_id) ?>">

                        <button type="submit" class="btn btn-success">
                            <i class="mdi mdi-file-excel"></i> Export Excel
                        </button>
                    </form> -->
                    <button onclick="exportTablesToExcel()" class="btn btn-success">
                        <i class="mdi mdi-file-excel"></i> Export to Excel
                    </button>
                    
                    <h5 class="mt-4 mb-3">Tabel Absensi</h5>
                    <div class="filter-scroll">
                        <table id="tabelAbsensi" class="table table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Division</th>
                                    <th>Plant</th>
                                    <th>Group</th>

                                    <?php foreach ($period as $date): ?>
                                        <th colspan="2" class="text-center"><?= $date->format('j M y') ?></th>
                                    <?php endforeach; ?>
                                    <th>Total Hadir</th>
                                    <th>Total Absent</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($employees as $emp): ?>
                                    <?php
                                    $totalHadir = 0;
                                    $totalAbsent = 0;
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $emp->employee_id ?></td>
                                        <td><?= strtoupper($emp->name) ?></td>
                                        <td><?= $emp->division ?></td>
                                        <td><?= $emp->plant ?></td>
                                        <td><?= $emp->employee_group ?></td>

                                        <?php foreach ($period as $date): ?>
                                            <?php
                                            $tgl = $date->format('Y-m-d');

                                            $in  = $scanMap[$emp->id][$tgl]['in'] ?? '-';
                                            $out = $scanMap[$emp->id][$tgl]['out'] ?? '-';

                                            if ($in != '-' || $out != '-') {
                                                $totalHadir++;
                                            } else {
                                                $totalAbsent++;
                                            }
                                            ?>
                                            <td><?= $in ?></td>
                                            <td><?= $out ?></td>
                                        <?php endforeach; ?>

                                        <td><?= $totalHadir ?></td>
                                        <td><?= $totalAbsent ?></td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>

                    <h5 class="mt-5 mb-3">Tabel Overtime</h5>
                    <div class="filter-scroll">
                        <table id="tabelOvertime" class="table table-bordered nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Division</th>
                                    <th>Plant</th>
                                    <th>Group</th>

                                    <?php foreach ($period as $date): ?>
                                        <th class="text-center"><?= $date->format('j M y') ?></th>
                                    <?php endforeach; ?>
                                    <th>Total Overtime</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($employees as $emp): ?>
                                    <?php
                                    $totalOvertimeMinutes = 0;
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $emp->employee_id ?></td>
                                        <td><?= strtoupper($emp->name) ?></td>
                                        <td><?= $emp->division ?></td>
                                        <td><?= $emp->plant ?></td>
                                        <td><?= $emp->employee_group ?></td>

                                        <?php foreach ($period as $date): ?>
                                            <?php
                                            $tgl = $date->format('Y-m-d');
                                            $ot  = $scanMap[$emp->id][$tgl]['overtime'] ?? '0.00';

                                            if ($ot != '0.00') {
                                                [$jam, $menit] = explode('.', $ot);
                                                $totalOvertimeMinutes += ((int)$jam * 60) + (int)$menit;
                                            }
                                            ?>

                                            <td class="text-center <?= $ot != '0.00' ? 'text-danger fw-bold' : '' ?>">
                                                <?php if ($ot != '0.00'): ?>
                                                    <?php [$jam, $menit] = explode('.', $ot); ?>
                                                    <?= $jam ?> Jam <?= str_pad($menit, 2, '0', STR_PAD_LEFT) ?> Menit
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                        <?php endforeach; ?>

                                        <?php
                                        $totalJam   = floor($totalOvertimeMinutes / 60);
                                        $totalMenit = $totalOvertimeMinutes % 60;

                                        $totalOT = $totalJam . ' Jam ' . str_pad($totalMenit, 2, '0', STR_PAD_LEFT).' Menit';
                                        ?>
                                        <td><?= $totalOT ?></td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>


<script>
function exportTablesToExcel() {
    var tableAbsensi = document.getElementById('tabelAbsensi');
    var tableOvertime = document.getElementById('tabelOvertime');
    
    // Check if tables exist
    if (!tableAbsensi || !tableOvertime) {
        alert('Tidak ada data untuk di-export. Silakan klik Search terlebih dahulu.');
        return;
    }
    
    // Trik CSS untuk border tipis (standard Excel look)
    var style = "<style>" +
                "table { border-collapse: collapse; width: 100%; margin-bottom: 30px; }" +
                "th, td { border: 0.5pt solid #000000; padding: 5px; }" +
                "th { background-color: #efefef; font-weight: bold; }" +
                "h3 { margin-top: 20px; margin-bottom: 10px; }" +
                "</style>";

    // Struktur XML untuk Excel dengan 2 tabel
    var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" ' +
                   'xmlns:x="urn:schemas-microsoft-com:office:excel" ' +
                   'xmlns="http://www.w3.org/TR/REC-html40">' +
                   '<head>' + style + '</head>' +
                   '<body>' +
                   '<h3>Tabel Absensi</h3>' +
                   tableAbsensi.outerHTML +
                   '<br><br>' +
                   '<h3>Tabel Overtime</h3>' +
                   tableOvertime.outerHTML +
                   '</body></html>';

    var blob = new Blob(['\ufeff', template], { type: 'application/vnd.ms-excel' });
    
    var filename = 'Report_Attendance_' + new Date().toISOString().slice(0,10) + '.xls';
    
    var downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);
    
    if (navigator.msSaveOrOpenBlob) {
        navigator.msSaveOrOpenBlob(blob, filename);
    } else {
        downloadLink.href = URL.createObjectURL(blob);
        downloadLink.download = filename;
        downloadLink.click();
    }
    document.body.removeChild(downloadLink);
}
</script>
<!-- container -->
<?= $this->endSection() ?>