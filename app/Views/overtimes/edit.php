<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('overtimes'); ?>">Overtimes</a></li>
                        <li class="breadcrumb-item active"><?= $title; ?></li>
                    </ol>
                </div>
                <h4 class="page-title"><?= $title; ?></h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">

                    <form action="<?= base_url('overtimes/update/' . $overtime->id); ?>" method="post">
                        <?= csrf_field(); ?>

                        <!-- ================= HEADER ================= -->
                        <div class="row">

                            <div class="col-md-2">
                                <label>Date</label>
                                <input type="date"
                                    name="overtime_date"
                                    class="form-control"
                                    value="<?= $overtime->overtime_date ?>">
                            </div>

                            <div class="col-md-2">
                                <label>Division</label>
                                <select id="division_id" name="division_id" class="form-control">
                                    <option value="">-- Select Division --</option>
                                    <?php foreach ($divisions as $d): ?>
                                        <option value="<?= $d->id ?>"
                                            <?= $d->id == $overtime->division_id ? 'selected' : '' ?>>
                                            <?= $d->name ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label>Sub Leader</label>
                                <select id="sub_leader_id" name="sub_leader_id" class="form-control">
                                    <option value="">-- Select Sub Leader --</option>
                                    <?php foreach ($sub_leaders as $s): ?>
                                        <option value="<?= $s->id ?>"
                                            <?= $s->id == $overtime->sub_leader_id ? 'selected' : '' ?>>
                                            <?= $s->name ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label>Category</label>
                                <select name="overtime_category_id" class="form-control">
                                    <option value="">-- Select Category --</option>
                                    <?php foreach ($categories as $c): ?>
                                        <option value="<?= $c->id ?>"
                                            <?= $c->id == $overtime->overtime_category_id ? 'selected' : '' ?>>
                                            <?= $c->name ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-1">
                                <label>Shift</label>
                                <select name="shift" class="form-control">
                                    <option value="D" <?= $overtime->shift == 'D' ? 'selected' : '' ?>>Day Shift</option>
                                    <option value="N" <?= $overtime->shift == 'N' ? 'selected' : '' ?>>Night Shift</option>
                                </select>
                            </div>

                            <div class="col-md-1">
                                <label>Group</label>
                                <select name="employee_group_id" class="form-control">
                                    <?php foreach ($group as $gr) { ?>
                                        <option value="<?= $gr->id ?>" <?= $overtime->employee_group_id == $gr->id ? 'selected' : '' ?>><?= $gr->name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label>Notes</label>
                                <input type="text"
                                    name="notes"
                                    class="form-control"
                                    value="<?= $overtime->notes ?>">
                            </div>

                        </div>

                        <hr>

                        <!-- ================= DETAIL ================= -->
                        <div id="detail-container">
                            <div class="row mb-1">

                                <div class="col-md-3">
                                    <label class="form-label">Employee</label>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Start</label>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">End</label>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Duration</label>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Task</label>
                                </div>

                                <div class="col-md-1"></div>

                            </div>

                            <?php foreach ($items as $i): ?>
                                <div class="row mb-2 detail-row">

                                    <div class="col-md-3">
                                        <select name="employee_id[]" class="form-control employee-select">
                                            <option value="">-- Select Employee --</option>
                                            <?php foreach ($employees as $e): ?>
                                                <option value="<?= $e->id ?>"
                                                    <?= $e->id == $i->employee_id ? 'selected' : '' ?>>
                                                    <?= $e->name ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <input type="time"
                                            name="start_time[]"
                                            class="form-control start-time"
                                            value="<?= $i->start_time ?>">
                                    </div>

                                    <div class="col-md-2">
                                        <input type="time"
                                            name="end_time[]"
                                            class="form-control end-time"
                                            value="<?= $i->end_time ?>">
                                    </div>

                                    <div class="col-md-2">
                                        <input type="number"
                                            step="0.01"
                                            name="duration_hours[]"
                                            class="form-control duration-hours"
                                            value="<?= $i->duration_hours ?>"
                                            readonly>
                                    </div>

                                    <div class="col-md-2">
                                        <input type="text"
                                            name="task_description[]"
                                            class="form-control"
                                            value="<?= $i->task_description ?>">
                                    </div>

                                    <div class="col-md-1 d-flex align-items-center">
                                        <input type="hidden" name="item_id[]" value="<?= $i->id ?>">
                                        <button type="button" class="btn btn-danger btn-sm remove-row" data-id="<?= $i->id ?>">x</button>
                                    </div>

                                </div>
                            <?php endforeach; ?>

                        </div>

                        <button type="button"
                            id="add-row"
                            class="btn btn-secondary btn-sm mb-3">
                            + Add Row
                        </button>

                        <div>
                            <button type="submit"
                                class="btn btn-primary">
                                Update
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</div>

<!-- ================= JS ================= -->
<script>
    console.log('OVERTIME JS LOADED');

    document.addEventListener('DOMContentLoaded', function() {

        let employeeCache = [];

        // ================= LOAD DIVISION DATA =================
        function loadDivisionData(divisionId) {

            if (!divisionId) return;

            // ================= SUB LEADER =================
            fetch("<?= base_url('overtimes/get-subleaders') ?>?division_id=" + divisionId)
                .then(res => res.json())
                .then(data => {

                    let sub = document.getElementById('sub_leader_id');

                    if (!sub) return;

                    let currentValue = sub.value;

                    sub.innerHTML =
                        '<option value="">-- Select Sub Leader --</option>';

                    data.forEach(item => {

                        let selected =
                            item.id == currentValue ?
                            'selected' :
                            '';

                        sub.innerHTML += `
                        <option value="${item.id}" ${selected}>
                            ${item.name}
                        </option>
                    `;
                    });

                });

            // ================= EMPLOYEES =================
            fetch("<?= base_url('overtimes/get-employees') ?>?division_id=" + divisionId)
                .then(res => res.json())
                .then(data => {

                    employeeCache = data;

                    refreshEmployees();

                });

        }

        // ================= REFRESH EMPLOYEES =================
        function refreshEmployees() {

            document.querySelectorAll('.employee-select').forEach(function(select) {

                let selectedValue = select.value;

                select.innerHTML =
                    '<option value="">-- Select Employee --</option>';

                employeeCache.forEach(function(emp) {

                    let selected =
                        emp.id == selectedValue ?
                        'selected' :
                        '';

                    select.innerHTML += `
                    <option value="${emp.id}" ${selected}>
                        ${emp.name}
                    </option>
                `;
                });

            });

        }

        // ================= AUTO LOAD EDIT =================
        let divisionEl = document.getElementById('division_id');

        if (divisionEl && divisionEl.value) {
            loadDivisionData(divisionEl.value);
        }

        // ================= DIVISION CHANGE =================
        if (divisionEl) {

            divisionEl.addEventListener('change', function() {

                console.log('DIVISION CHANGE FIRED:', this.value);

                loadDivisionData(this.value);

            });

        }

        // ================= ADD ROW =================
        document.getElementById('add-row').addEventListener('click', function() {

            let options =
                '<option value="">-- Select Employee --</option>';

            employeeCache.forEach(function(e) {

                options += `
                <option value="${e.id}">
                    ${e.name}
                </option>
            `;

            });

            let row = document.createElement('div');

            row.classList.add(
                'row',
                'mb-2',
                'detail-row'
            );

            row.innerHTML = `
            <div class="col-md-3">
                <select name="employee_id[]" class="form-control employee-select">
                    ${options}
                </select>
            </div>

            <div class="col-md-2">
                <input type="time" name="start_time[]" class="form-control start-time">
            </div>

            <div class="col-md-2">
                <input type="time" name="end_time[]" class="form-control end-time">
            </div>

            <div class="col-md-2">
                <input type="number"
                    step="0.01"
                    name="duration_hours[]"
                    class="form-control duration-hours"
                    readonly>
            </div>

            <div class="col-md-2">
                <input type="text"
                    name="task_description[]"
                    class="form-control">
            </div>

            <div class="col-md-1">
                <button type="button"
                    class="btn btn-danger btn-sm remove-row">
                    x
                </button>
            </div>
        `;

            document
                .getElementById('detail-container')
                .appendChild(row);

        });

        // ================= REMOVE ROW =================
        document.addEventListener('click', function(e) {

            if (e.target.classList.contains('remove-row')) {

                let rows =
                    document.querySelectorAll('.detail-row');

                if (rows.length > 1) {
                    e.target
                        .closest('.detail-row')
                        .remove();
                }

            }

        });

    });

    function calculateDuration(start, end) {

        if (!start || !end) return 0;

        let startTime = new Date("1970-01-01T" + start + ":00");
        let endTime = new Date("1970-01-01T" + end + ":00");

        let diff = (endTime - startTime) / 1000 / 60 / 60; // jam

        // kalau lewat tengah malam (antisipasi)
        if (diff < 0) {
            diff = diff + 24;
        }

        return Math.round(diff * 100) / 100; // 2 desimal
    }

    document.addEventListener('input', function(e) {

        // hanya trigger kalau input time
        if (e.target.type === 'time') {

            let row = e.target.closest('.detail-row');

            if (!row) return;

            let startEl = row.querySelector('input[name="start_time[]"]');
            let endEl = row.querySelector('input[name="end_time[]"]');
            let result = row.querySelector('input[name="duration_hours[]"]');

            if (!startEl || !endEl || !result) {
                console.log('ELEMENT MISSING IN ROW');
                return;
            }

            let start = startEl.value;
            let end = endEl.value;

            if (!start || !end) {
                result.value = '';
                return;
            }

            let startTime = new Date("1970-01-01T" + start + ":00");
            let endTime = new Date("1970-01-01T" + end + ":00");

            let diff = (endTime - startTime) / 1000 / 60 / 60;

            if (diff < 0) diff += 24;

            result.value = Math.round(diff * 100) / 100;

            console.log('DURATION:', start, end, result.value);
        }

    });
</script>

<?= $this->endSection() ?>