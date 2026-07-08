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
                    <form class="needs-validation" novalidate action="<?= base_url('overtime/report_user'); ?>" method="post">
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
                                <label class="form-label">Employee</label>
                                <select name="employee_id" class="form-control select2" data-toggle="select2">
                                    <option value="0">-- All --</option>
                                    <?php foreach ($employee as $p): ?>
                                        <option value="<?= $p->id; ?>" <?= $employee_id == $p->id ? 'selected' : ''; ?>>
                                            <?= $p->name; ?>
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
                    <div class="col-xl-1 col-sm-12 mb-3">
                        <form action="<?= base_url('overtime/export2'); ?>" method="post">
                            <input type="hidden" name="start_date" value="<?= $start_date; ?>">
                            <input type="hidden" name="end_date" value="<?= $end_date; ?>">
                            <input type="hidden" name="employee_id" value="<?= $employee_id; ?>">
                            <div class="mb-2">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success">Export</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <h4>Date Range : <?= date('d-M-Y', strtotime($start_date)) . ' - ' . date('d-M-Y', strtotime($end_date)); ?></h4>
                    <table id="basic-datatable" class="table table-bordered table-striped nowrap w-100" style="min-width: max-content;">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Name</td>
                                <td>Date</td>
                                <td>Overtime</td>
                                <td>Jobdesk</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            $no = 1;
                            foreach ($overtime_data as $item):
                                $total_hours = (float) $item['total_hours'];
                                $total += $total_hours;
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $item['name'] ?></td>
                                    <td><?= date('d-m-Y', strtotime($item['date'])) ?></td>
                                    <td class="text-end"><?= $item['total_hours'] ?></td>
                                    <td><?= $item['jobdesk'] ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end">Total</td>
                                <td class="text-end"><?= number_format($total, 2) ?></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>