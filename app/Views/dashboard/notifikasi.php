<?= $this->extend('layout/index') ?>

<?= $this->section('content') ?>
<!-- Start Content-->
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
                    <div class="row">
                        <div class="col-xl-12 col-sm-12">
                            <h5>Contract</h5>
                            <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Employee ID</th>
                                    <th>Position</th>
                                    <th>Plant</th>
                                    <th>Group</th>
                                    <th>Contract</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Link</th>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($contract as $row): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $row->name; ?></td>
                                            <td><?= $row->employee_id; ?></td>
                                            <td><?= $row->position; ?></td>
                                            <td><?= $row->plant; ?></td>
                                            <td><?= $row->employee_group; ?></td>
                                            <td><?= $row->contract; ?></td>
                                            <td><?= $row->start_date; ?></td>
                                            <td><?= $row->end_date; ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('contract/employee/' . $row->employee_id); ?>" target="_blank" class="btn btn-info btn-sm"><i class="mdi mdi-pencil"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4 col-sm-12">
                            <h5>SIM Expired</h5>
                            <table id="selection-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Division</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($simexpired as $row): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= strtoupper($row->name); ?></td>
                                            <td><?= $row->division; ?></td>
                                            <td class="text-danger"><?= date('d-M-Y', strtotime($row->masa_berlaku)); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-xl-4 col-sm-12">
                            <h5>STNK pajak tahunan expired</h5>
                            <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Division</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($stnkexpired as $row): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $row->name; ?></td>
                                            <td><?= $row->division; ?></td>
                                            <td class="text-danger"><?= date('d-M-Y', strtotime($row->masa_berlaku_pajak)); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-xl-4 col-sm-12">
                            <h5>STNK pajak 5 tahunan expired</h5>
                            <table id="alternative-page-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Division</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($platexpired as $row): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $row->name; ?></td>
                                            <td><?= $row->division; ?></td>
                                            <td class="text-danger"><?= date('d-M-Y', strtotime($row->masa_berlaku_plat)); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>