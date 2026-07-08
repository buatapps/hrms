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
                        <h1>Selamat Datang, <?= user()->username; ?></h1>
                        <h5 class="fst-italic">"Selamat bekerja dan berkarya dengan sistem HRMS Namicoh Indonesia"</h5>

                        <div class="row">
                            <h6 class="mt-lg-4 mb-lg-4">Quick Access</h6>
                            <div class="col-3 center-icon">
                                <a href="<?= base_url('dashboard/dashboard_employee'); ?>">
                                    <span class="icon-circle">
                                        <i class="uil uil-users-alt"></i>
                                    </span>
                                </a>
                                <p class="text-center mt-md-2">Dashboard Employee</p>
                            </div>
                            <div class="col-3 center-icon">
                                <a href="<?= base_url('attendance/download/0'); ?>">
                                    <span class="icon-circle">
                                        <i class="uil uil-cloud-download "></i>
                                    </span>
                                </a>
                                <p class="text-center mt-md-2">Download Attendance</p>
                            </div>
                            <div class="col-3 center-icon">
                                <a href="<?= base_url('employee'); ?>">
                                    <span class="icon-circle">
                                        <i class="uil uil-server-connection"></i>
                                    </span>
                                </a>
                                <p class="text-center mt-md-2">Data Employee</p>
                            </div>
                            <div class="col-3 center-icon">
                                <a href="<?= base_url('dashboard/late'); ?>">
                                    <span class="icon-circle">
                                        <i class="uil uil-clock-seven "></i>
                                    </span>
                                </a>
                                <p class="text-center mt-md-2">Employee Late</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container -->
    <style>
        .icon-circle {
            width: 56px;
            height: 56px;
            border: 2px solid #ddd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            /* center vertikal */
            justify-content: center;
            /* center horizontal */
            font-size: 32px
        }

        .center-icon {
            display: flex;
            flex-direction: column;
            /* ini kuncinya */
            align-items: center;
            justify-content: center;
        }
    </style>
    <?= $this->endSection() ?>