<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
<!-- Start Content-->
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('attendance/absent'); ?>">Absent</a></li>
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

                    <form class="needs-validation" novalidate action="<?= base_url('attendance/absent_save'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <select name="employee_id" class="form-control select2" data-toggle="select2">
                                        <?php foreach ($employee as $row): ?>
                                            <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date</label>
                                    <input type="date" class="form-control" name="date" value="<?= old('date', $date); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">End Date</label>
                                    <input type="date" class="form-control" name="end_date" value="<?= old('end_date', $date); ?>" required>
                                </div>


                            </div>
                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Absent Type</label>
                                    <select name="absent_type_id" id="absent_type_id" class="form-control">
                                        <?php foreach ($absent_type as $row) { ?>
                                            <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Time Hour</label>
                                    <input type="time" name="late_hour" id="late_hour" class="form-control" value="<?= old('late_hour'); ?>">
                                    <p class="text-muted">*Terlambat, Absen Manual, LC, EG wajib di isi</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Information</label>
                                    <textarea name="information" class="form-control" style="height: 130px;" placeholder="keterangan status / keterangan waktu"></textarea>
                                </div>

                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const absentType = document.getElementById('absent_type_id');
        const lateHour = document.getElementById('late_hour');

        const requiredTypes = ['4', '5', '6', '7'];

        function checkLateHour() {
            if (requiredTypes.includes(absentType.value)) {
                lateHour.setAttribute('required', 'required');
            } else {
                lateHour.removeAttribute('required');
                lateHour.value = ''; // optional: reset
            }
        }

        absentType.addEventListener('change', checkLateHour);

        // run saat pertama load
        checkLateHour();
    });
</script>
<!-- container -->
<?= $this->endSection() ?>