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
                        <li class="breadcrumb-item"><a href="<?= base_url('account'); ?>">Management Account</a></li>
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
                    <form class="needs-validation" novalidate action="<?= base_url('account/update/' . $list_data->id); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-4 col-sm-12">
                                <input type="hidden" value="<?= $list_data->username; ?>" name="oldusername">
                                <input type="hidden" value="<?= $list_data->email; ?>" name="oldemail">
                                <div class="mb-2">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control <?= (validation_show_error('username')) ? 'is-invalid' : ''; ?>" name="username" value="<?= old('username', $list_data->username) ?>" autofocus required>
                                    <div class="invalid-feedback">
                                        <?= validation_show_error('username') ?>
                                    </div>

                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control <?= (validation_show_error('email')) ? 'is-invalid' : ''; ?>" name="email" value="<?= old('email', $list_data->email) ?>" autofocus required>
                                    <div class="invalid-feedback">
                                        <?= validation_show_error('email') ?>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Group</label>
                                    <select class="form-select mb-3" name="group_id">
                                        <?php foreach ($auth_groups as $group) : ?>
                                            <option value="<?= $group->id; ?>" <?= ($group->id == $list_data->group_id) ? 'selected' : '' ?>><?= $group->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Division</label>
                                    <select class="form-select mb-3" name="division_id">
                                        <option value="">-- Tidak ada --</option>
                                        <?php foreach ($division as $div) : ?>
                                            <option value="<?= $div->id; ?>" <?= ($div->id == $list_data->division_id) ? 'selected' : '' ?>><?= $div->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="oldimage" value="<?= $list_data->image; ?>">
                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-2">
                                    <label class="form-label">Image</label>
                                    <input class="form-control" type="file" name="image" id="sampul" onchange="previewImg()">
                                </div>
                                <div class="mb-2">
                                    <img src="<?= base_url('assets/images/users/' . $list_data->image); ?>" height="120" alt="" class="img-preview">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>