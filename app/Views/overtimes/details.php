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

    <!-- ================= HEADER ================= -->
    <div class="card mb-3">
        <div class="card-body">
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <h4><?= $overtime->overtime_number ?></h4>

            <div class="row">

                <div class="col-md-2">
                    <strong>Date:</strong><br>
                    <?= $overtime->overtime_date ?>
                </div>

                <div class="col-md-2">
                    <strong>Division:</strong><br>
                    <?= $overtime->division_name ?>
                </div>

                <div class="col-md-2">
                    <strong>Shift:</strong><br>
                    <?php if ($overtime->shift == 'D') { ?>
                        <strong>Day Shift</strong>
                    <?php } else { ?>
                        <strong>Night Shift</strong>
                    <?php } ?>
                </div>

                <div class="col-md-2">
                    <strong>Group:</strong><br>
                    <?= $overtime->employee_group ?>
                </div>

                <div class="col-md-2">
                    <strong>Categories:</strong><br>
                    <?= $overtime->overtime_categories_name ?>
                </div>

                <div class="col-md-2">
                    <strong>Approval:</strong><br>
                    <?= $overtime->overtime_approval ?>
                </div>

            </div>

            <hr>
            <div>
                <strong>Notes:</strong><br>
                <?= $overtime->notes ?>
            </div>

            <div class="mt-2">
                <strong>Status:</strong>
                <span class="badge bg-info"><?= $overtime->final_status ?></span>
            </div>

        </div>
    </div>

    <!-- FORM Approval -->
     <?php if(!in_groups('assistant-manager')&& !in_groups('senior-manager')){ ?>
    <div class="card">
        <div class="card-body">
            <form action="<?= base_url('overtimes/approval'); ?>" method="post">
                <div class="col-md-4">
                    <label>Approval Manual</label>

                    <div class="d-flex gap-2">
                        <input type="hidden" name="overtimes_id" value="<?= $overtime->id; ?>">
                        <select name="current_approval_level" class="form-control">
                            <?php foreach ($approval as $app) { ?>
                                <option value="<?= $app->id; ?>" <?= $app->id == $overtime->current_approval_level ? 'selected' : '' ?>><?= $app->name; ?></option>
                            <?php } ?>
                        </select>

                        <button type="submit" class="btn btn-info btn-sm">
                            Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php } ?>
    <?php if(in_groups('assisten-manager')){ ?>
    <div class="card">
        <div class="card-body">
            <h5>Approval Assisten Manager</h5>
            <?php if($overtime->current_approval_level == 1){ ?>
            <form action="<?= base_url('overtimes/approval'); ?>" method="post" id="form-approve">
                <div class="row">
                    <input type="hidden" name="overtimes_id" value="<?= $overtime->id; ?>">
                    <input type="hidden" name="current_approval_level" value="2">
                    <div class="col-2">
                        <button type="submit" class="btn btn-info w-100 btn-sm btn-block btn-approve">
                            Approve
                        </button>
                    </div>
                </div>
            </form>
            <?php }else { ?>
                <p>Approval Done!.</p>
            <?php } ?>
        </div>
    </div>
    <?php } ?>
    <?php if(in_groups('senior-manager')){ ?>
    <div class="card">
        <div class="card-body">
            <h5>Approval Senior Manager</h5>
            <?php if($overtime->current_approval_level == 2){ ?>
            <form action="<?= base_url('overtimes/approval'); ?>" method="post" id="form-approve">
                <div class="row">
                    <input type="hidden" name="overtimes_id" value="<?= $overtime->id; ?>">
                    <input type="hidden" name="current_approval_level" value="3">
                    <div class="col-2">
                        <button type="submit" class="btn btn-info w-100 btn-sm btn-block btn-approve">
                            Approve
                        </button>
                    </div>
                </div>
            </form>
            <?php }else { ?>
                <p>Approval Done!.</p>
            <?php } ?>
        </div>
    </div>
    <?php } ?>
    <!-- ================= ITEMS ================= -->
    <div class="card">
        <div class="card-body">

            <h5>Overtime Details</h5>
            <div class="row mb-2">
                <div class="col-6">
                        <a href="<?= base_url('overtimes/print/' . $overtime->id); ?>" target="_blank" class="btn btn-sm btn-warning mt-2"><i class="mdi mdi-printer"></i></a>
                </div>
                <div class="col-6 text-end">
                        <a href="<?= base_url('overtimes/cancel/' . $overtime->id); ?>" class="btn btn-sm btn-danger mt-2 btn-cancel">Cancel</a>
                </div>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Employee</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Actual Start</th>
                        <th>Actual End</th>
                        <th>Duration</th>
                        <th>Task</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1;
                    foreach ($items['items'] as $i): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $i->employee_name ?></td>
                            <td><?= $i->start_time ?></td>
                            <td><?= $i->end_time ?></td>
                            <td class="text-info">
                                <strong><?= $i->actual_start ?></strong>
                            </td>
                            <td class="text-info">
                                <strong><?= $i->actual_end ?></strong>
                            </td>
                            <td><?= $i->duration_hours ?></td>
                            <td><?= $i->task_description ?></td>
                            <td>
                                <?php if ($i->not_approve == 0) { ?>
                                    <strong class="text-success">Approved</strong>
                                <?php } else { ?>
                                    <strong class="text-danger">Not Approved</strong>
                                <?php } ?>
                            </td>
                            <td class="text-center">
                                <?php if ($i->not_approve == 0) { ?>
                                    <a href="<?= base_url('overtimes/notapproval/' . $overtime->overtimes_id . '/' . $i->overtime_items_id); ?>" class="btn btn-danger btn-sm">Not Approve</a>
                                <?php } else { ?>
                                    <a href="<?= base_url('overtimes/cancelnotapproval/' . $overtime->overtimes_id . '/' . $i->overtime_items_id) ?> ?>" class="btn btn-warning btn-sm">Cancel</a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>

        </div>
        <a href="<?= base_url('overtimes'); ?>" class="btn btn-secondary btn-sm m-2">Back</a>
    </div>

</div>

<?= $this->endSection() ?>