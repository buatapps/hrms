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
                        <li class="breadcrumb-item"><a href="<?= base_url('ticket'); ?>">Ticket</a></li>
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
                    <form class="needs-validation" novalidate action="<?= base_url('ticket/update'); ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" name="id" value="<?= $list_data->id; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date</label>
                                    <input type="date" class="form-control" name="date" value="<?= $list_data->date; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <select name="employee_id" class="form-control select2" data-toggle="select2">
                                        <?php foreach ($employee as $row): ?>
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $list_data->employee_id) ? 'selected' : null ?>><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Category</label>
                                    <select name="ticket_category_id" class="form-control">
                                        <?php foreach ($category as $row): ?>
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $list_data->ticket_category_id) ? 'selected' : null ?>><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title" value="<?= $list_data->title; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control"><?= $list_data->description; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Solution</label>
                                    <textarea name="solution" class="form-control"><?= $list_data->solution; ?></textarea>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Priority</label>
                                    <select name="priority" class="form-control">
                                        <option value="low" <?= ('low' == $list_data->priority) ? 'selected' : null ?>>LOW</option>
                                        <option value="medium" <?= ('medium' == $list_data->priority) ? 'selected' : null ?> selected>MEDIUM</option>
                                        <option value="high" <?= ('high' == $list_data->priority) ? 'selected' : null ?>>HIGH</option>
                                        <option value="critical" <?= ('critical' == $list_data->priority) ? 'selected' : null ?>>CRITICAL</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="ticket_status_id" class="form-control">
                                        <?php foreach ($status as $row): ?>
                                            <option value="<?= $row->id; ?>" <?= ($row->id == $list_data->ticket_status_id) ? 'selected' : null ?>><?= $row->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Attachment</label>
                                    <input type="file" name="attachment" class="form-control">
                                    <p>Old file : <a href="<?= base_url('attachment/' . $list_data->attachment); ?>">Download</a></p>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                <a href="<?= base_url('ticket/closed/' . $list_data->id); ?>" class="btn btn-sm btn-danger">Closed</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>