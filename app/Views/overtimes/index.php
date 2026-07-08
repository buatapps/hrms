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
                    <?php if(!in_groups('assistant-manager')&& !in_groups('senior-manager')){ ?>
                        <div class="row mb-2">
                            <div class="col-xl-2 col-sm-12">
                                <div class="mt-2">
                                    <a href="<?= base_url('overtimes/add'); ?>" class="btn btn-success mb-2 me-2"><i class="mdi mdi-plus me-1"></i> Add New</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                        
                    <?php if (session('success')) : ?>
                        <div class="mt-2">
                            <div class="alert alert-success" role="alert">
                                <i class="ri-check-line me-2"></i>
                                <?= session('success'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <form class="needs-validation" novalidate action="<?= base_url('overtimes/search'); ?>" method="get">

                        <div class="row">

                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Start Date</label>
                                    <input type="date"
                                        class="form-control"
                                        name="start_date"
                                        value="<?= old('start_date', $start_date); ?>">
                                </div>
                            </div>

                            <div class="col-xl-2 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">End Date</label>
                                    <input type="date"
                                        class="form-control"
                                        name="end_date"
                                        value="<?= old('end_date', $end_date); ?>">
                                </div>
                            </div>

                            <div class="col-xl-2 col-sm-12">
                                <label class="form-label">&nbsp;</label>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-info">
                                        Search
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Number</th>
                                <th>Date</th>
                                <th>Division</th>
                                <th>Sub Leader</th>
                                <th>Category</th>
                                <th>Shift</th>
                                <th>Group</th>
                                <th>App. Level</th>
                                <th>Status</th>
                                <th>List Emp.</th>
                                <th>Print</th>
                                <?php if(!in_groups('assistant-manager')&& !in_groups('senior-manager')){ ?>
                                <th class="text-center">Aksi</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($list_data as $row): ?>
                                <tr>
                                    <td><?= $no++; ?></td>

                                    <td>
                                        <a href="<?= base_url('overtimes/details/' . $row->id); ?>">
                                            <?= esc($row->overtime_number); ?>
                                        </a>
                                    </td>

                                    <td><?= date('d M Y', strtotime($row->overtime_date)); ?></td>

                                    <td><?= esc($row->division_name ?? '-'); ?></td>

                                    <td><?= esc($row->sub_leader_name ?? '-'); ?></td>

                                    <td><?= esc($row->category_name ?? '-'); ?></td>

                                    <td><?php if ($row->shift == 'D') { ?>
                                            Day Shift
                                        <?php } else { ?> Night Shift <?php } ?></td>

                                    <td><?= esc($row->employee_group); ?></td>

                                    <td>
                                        <?= $row->overtime_approval; ?>
                                    </td>

                                    <td>
                                        <?php if ($row->final_status == 'approved'): ?>
                                            <span class="badge bg-success">Approved</span>

                                        <?php elseif ($row->final_status == 'cancelled'): ?>
                                            <span class="badge bg-danger">Cancelled</span>

                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Progress</span>
                                        <?php endif; ?>
                                    </td>

                                    

                                    

                                    <td class="text-center">
                                        <a href="<?= base_url('overtimes/details/' . $row->id); ?>" class="btn btn-sm btn-primary" title="View Employee List">
                                            View
                                        </a>
                                    </td>
                                    
                                    <td class="text-center">
                                        <a href="<?= base_url('overtimes/print/' . $row->id); ?>" class="btn btn-sm btn-warning" target="_blank" title="Print">
                                            <i class="mdi mdi-printer"></i>
                                        </a>
                                    </td>

                                    
                                    <?php if(!in_groups('assistant-manager')&& !in_groups('senior-manager')){ ?>
                                    <td class="text-center">
                                        <a href="<?= base_url('overtimes/edit/' . $row->id); ?>" class="btn btn-sm btn-info" title="Edit">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                        <a href="<?= base_url('overtimes/delete/' . $row->id); ?>"
                                            onclick="return confirm('delete?')"
                                            class="btn btn-sm btn-danger" title="Delete">
                                            <i class="mdi mdi-delete"></i>
                                        </a>
                                        <?php if ($row->current_approval_level != '3') { ?>
                                            <a href="<?= base_url('overtimes/send_mail/' . $row->id); ?>" class="btn btn-sm btn-dark" title="Send Email">
                                                <i class="mdi mdi-email-send"></i>
                                            </a>
                                        <?php }?>
                                    </td>
                                    <?php } ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>