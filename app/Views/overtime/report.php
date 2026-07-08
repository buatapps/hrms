<?= $this->extend('layout/index') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- Title -->
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

    <!-- Filter -->
    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form class="needs-validation" novalidate action="<?= base_url('overtime/report'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-2">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="start_date" class="form-control" value="<?= $start_date; ?>">
                            </div>
                            <div class="col-xl-2">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-control" value="<?= $end_date; ?>">
                            </div>
                            <div class="col-xl-2">
                                <label class="form-label">Plant</label>
                                <select name="plant_id" class="form-control">
                                    <option value="0">-- All --</option>
                                    <?php foreach ($plant as $p): ?>
                                        <option value="<?= $p->id; ?>" <?= $plant_id == $p->id ? 'selected' : ''; ?>>
                                            <?= $p->name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-xl-2">
                                <label class="form-label">Group</label>
                                <select name="employee_group_id" class="form-control">
                                    <option value="0">-- All --</option>
                                    <?php foreach ($group as $g): ?>
                                        <option value="<?= $g->id; ?>" <?= $employee_group_id == $g->id ? 'selected' : ''; ?>>
                                            <?= $g->name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-xl-2">
                                <label class="form-label d-block">&nbsp;</label>
                                <button type="submit" class="btn btn-sm btn-info">Search</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <div class="col-xl-1 col-sm-12">
                        <form action="<?= base_url('overtime/export'); ?>" method="post">
                            <input type="hidden" name="start_date" value="<?= $start_date; ?>">
                            <input type="hidden" name="end_date" value="<?= $end_date; ?>">
                            <input type="hidden" name="plant_id" value="<?= $plant_id; ?>">
                            <input type="hidden" name="employee_group_id" value="<?= $employee_group_id; ?>">
                            <div class="mb-2">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success">Export</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <table id="basic-datatable" class="table table-bordered table-striped nowrap w-100" style="min-width: max-content;">
                        <thead>
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Name</th>
                                <th rowspan="2">Plant</th>
                                <th rowspan="2">Group</th>
                                <th colspan="<?= count($period); ?>" class="text-center">Dates</th>
                                <th rowspan="2">Total</th>
                            </tr>
                            <tr>
                                <?php foreach ($period as $date): ?>
                                    <th class="text-center"><?= date('d', strtotime($date)); ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($employees as $emp): ?>
                                <?php $total = 0; ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $emp->name; ?></td>
                                    <td><?= $emp->plant; ?></td>
                                    <td><?= $emp->employee_group; ?></td>
                                    <?php foreach ($period as $date): ?>
                                        <?php
                                        $hours = $ot_map[$emp->id][$date] ?? '';
                                        if ($hours !== '') $total += $hours;
                                        ?>
                                        <td class="text-center"><?= $hours !== '' ? $hours : ''; ?></td>
                                    <?php endforeach; ?>
                                    <td class="text-center font-weight-bold"><?= $total; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS Sticky -->
<style>
    .sticky-col {
        position: sticky;
        left: 0;
        background: #fff;
        z-index: 5;
    }

    .sticky-end {
        position: sticky;
        right: 0;
        background: #fff;
        z-index: 5;
    }

    th,
    td {
        white-space: nowrap;
    }
</style>

<!-- DataTables ScrollX -->
<script>
    $(document).ready(function() {
        $('#basic-datatable').DataTable({
            scrollX: true,
            ordering: false,
            paging: false,
            searching: false
        });
    });
</script>

<?= $this->endSection() ?>