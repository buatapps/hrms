<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
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

    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-xl-4 col-sm-12">
                            <div class="d-flex flex-wrap gap-2">
                                <a href="<?= base_url('employee/idcard/print'); ?>" id="print-all-card" class="btn btn-primary" target="_blank"><i class="mdi mdi-printer me-1"></i> Print All Card</a>
                                <a href="<?= base_url('employee/idcard/print-back'); ?>" id="print-back-all" class="btn btn-outline-primary" target="_blank"><i class="mdi mdi-printer me-1"></i> Print Back All</a>
                            </div>
                        </div>
                    </div>

                    <form action="<?= base_url('employee/idcard'); ?>" method="get" id="idcard-filter-form">
                        <div class="row mb-3">
                            <div class="col-xl-3 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Division</label>
                                    <select name="division_id" class="form-control select2">
                                        <option value="">-- All --</option>
                                        <?php foreach ($division as $row): ?>
                                            <option value="<?= $row->id ?>" <?= $row->id == $division_id ? 'selected' : '' ?>><?= esc($row->name) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-3 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Plant</label>
                                    <select name="plant_id" class="form-control select2">
                                        <option value="">-- All --</option>
                                        <?php foreach ($plant as $row): ?>
                                            <option value="<?= $row->id ?>" <?= $row->id == $plant_id ? 'selected' : '' ?>><?= esc($row->name) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-3 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Group</label>
                                    <select name="employee_group_id" class="form-control select2">
                                        <option value="">-- All --</option>
                                        <?php foreach ($group as $row): ?>
                                            <option value="<?= $row->id ?>" <?= $row->id == $employee_group_id ? 'selected' : '' ?>><?= esc($row->name) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-3 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Print Option</label>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="mirror" value="1" id="mirror" <?= $mirror ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="mirror">Mirror</label>
                                    </div>
                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                        <button type="button" id="print-filtered" class="btn btn-success"><i class="mdi mdi-printer me-1"></i> Print</button>
                                        <button type="button" id="print-back-filtered" class="btn btn-outline-success"><i class="mdi mdi-printer me-1"></i> Print Back</button>
                                        <?php if ($has_filter): ?>
                                            <a href="<?= base_url('employee/idcard') . ($mirror ? '?mirror=1' : ''); ?>" class="btn btn-secondary">Reset</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Division</th>
                                <th class="text-center">Print</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($list_data as $row): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= esc($row['employee_id']); ?></td>
                                    <td><?= esc($row['name']); ?></td>
                                    <td><?= esc($row['position']); ?></td>
                                    <td><?= esc($row['division']); ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('employee/idcard/print/' . $row['id']); ?>" data-url="<?= base_url('employee/idcard/print/' . $row['id']); ?>" class="action-icon text-primary print-single-card" target="_blank"><i class="mdi mdi-printer"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('idcard-filter-form');
        const mirror = document.getElementById('mirror');
        const printAll = document.getElementById('print-all-card');
        const printBackAll = document.getElementById('print-back-all');
        const printSingles = document.querySelectorAll('.print-single-card');
        const printFiltered = document.getElementById('print-filtered');
        const printBackFiltered = document.getElementById('print-back-filtered');

        const updatePrintLinks = function () {
            const suffix = mirror.checked ? '?mirror=1' : '';
            printAll.href = '<?= base_url('employee/idcard/print'); ?>' + suffix;
            printBackAll.href = '<?= base_url('employee/idcard/print-back'); ?>' + suffix;
            printSingles.forEach(function (link) {
                link.href = link.dataset.url + suffix;
            });
        };

        const buildPrintQuery = function () {
            const params = new URLSearchParams();
            for (const [key, value] of new FormData(form).entries()) {
                if (value !== '') {
                    params.append(key, value);
                }
            }
            const query = params.toString();
            return query ? '?' + query : '';
        };

        mirror.addEventListener('change', updatePrintLinks);
        printFiltered.addEventListener('click', function () {
            window.open('<?= base_url('employee/idcard/print'); ?>' + buildPrintQuery(), '_blank');
        });
        printBackFiltered.addEventListener('click', function () {
            window.open('<?= base_url('employee/idcard/print-back'); ?>' + buildPrintQuery(), '_blank');
        });
        updatePrintLinks();
    });
</script>
<?= $this->endSection() ?>
