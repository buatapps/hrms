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
                    <p>Date : <?= date('d/m/Y', strtotime($date)); ?></p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5>Count Makan</h5>
                    <div class="row text-center">
                        <?php
                        $all_status = ['MAKAN', 'TIDAK MAKAN', 'PUASA', 'TIDAK PUASA', 'DIET'];
                        foreach ($all_status as $index => $status):
                            $offset = ($index === 0) ? 'offset-xl-1' : (($index === 3) ? 'offset-xl-2' : '');
                            $count = $counts[$status] ?? 0;
                        ?>
                            <div class="col-xl-3 <?= $offset ?> mb-4">
                                <div class="card border border-primary shadow-sm">
                                    <div class="card-body text-center">
                                        <h5 class="text-primary fw-bold mb-2"><?= $status; ?></h5>
                                        <h2 class="mb-0"><?= $count; ?></h2>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>