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
                        <li class="breadcrumb-item"><a href="<?= base_url('working_days'); ?>">Working Hours</a></li>
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

                    <form class="needs-validation" novalidate action="<?= base_url('working_days/save'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="col-xl-4 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label">Shift</label>
                                <select name="shift_id" class="form-control">
                                    <?php foreach ($shift as $row): ?>
                                        <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Working Hours</label>
                                <select name="working_hours_id" class="form-control">
                                    <?php foreach ($workinghours as $row): ?>
                                        <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-sm-12">
                            <div class="mb-3">
                                <label class="form-label">Days</label>
                                <div class="mt-2">
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" class="form-check-input" id="customCheck1" value="Monday" name="day[]">
                                        <label class="form-check-label" for="customCheck1">Monday</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" class="form-check-input" id="customCheck2" value="Tuesday" name="day[]">
                                        <label class="form-check-label" for="customCheck2">Tuesday</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" class="form-check-input" id="customCheck3" value="Wednesday" name="day[]">
                                        <label class="form-check-label" for="customCheck3">Wednesday</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" class="form-check-input" id="customCheck4" value="Thursday" name="day[]">
                                        <label class="form-check-label" for="customCheck4">Thursday</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" class="form-check-input" id="customCheck5" value="Friday" name="day[]">
                                        <label class="form-check-label" for="customCheck5">Friday</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" class="form-check-input" id="customCheck6" value="Saturday" name="day[]">
                                        <label class="form-check-label" for="customCheck6">Saturday</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" class="form-check-input" id="customCheck7" value="Sunday" name="day[]">
                                        <label class="form-check-label" for="customCheck7">Sunday</label>
                                    </div>
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
<!-- container -->
<?= $this->endSection() ?>