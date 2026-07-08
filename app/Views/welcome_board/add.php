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
                        <li class="breadcrumb-item"><a href="<?= base_url('welcome_board'); ?>">welcome_board</a></li>
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

                    <form class="needs-validation" novalidate action="<?= base_url('welcome_board/save'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Guest</label>
                                    <select name="guest_id" class="form-control">
                                        <?php foreach ($guest as $row) : ?>
                                            <option value="<?= $row->id; ?>"><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Topic</label>
                                    <input type="text" class="form-control" name="topic" value="<?= old('topic'); ?>" required>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" class="form-control" name="start_date" value="<?= old('date_start', date('Y-m-d')); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">End Date</label>
                                    <input type="date" class="form-control" name="end_date" value="<?= old('date_end', date('Y-m-d')); ?>" required>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Start Time</label>
                                    <input type="text" class="form-control" name="start_time" value="<?= old('date_start'); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">End Time</label>
                                    <input type="text" class="form-control" name="end_time" value="<?= old('date_start'); ?>" required>
                                </div>
                            </div>
                        </div>
                        <h6>List Member</h6>
                        <?php for ($i = 0; $i < 6; $i++) { ?>
                            <div class="row">
                                <div class="col-xl-4 col-sm-12">
                                    <div class="mb-1">
                                        <label class="form-label">Member Guest</label>
                                        <input type="text" class="form-control" name="member_guest[]" value="<?= old('member_guest'); ?>">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-sm-12">
                                    <div class="mb-1">
                                        <label class="form-label">Member Information</label>
                                        <input type="text" class="form-control" name="member_information[]" value="<?= old('member_information'); ?>">
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <button type="submit" class="btn btn-sm btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>