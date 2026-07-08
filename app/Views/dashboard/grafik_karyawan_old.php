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
                    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
                    <h5>Grafik Karyawan</h5>
                    <div id="grafik-karyawan"></div>
                    <script>
                        var options = {
                            chart: {
                                type: 'bar',
                                height: 500
                            },
                            series: [{
                                name: 'Jumlah Karyawan',
                                data: <?= $data ?>
                            }],
                            xaxis: {
                                type: 'category',
                                labels: {
                                    rotate: -45,
                                    style: {
                                        fontSize: '12px',
                                        fontWeight: 'bold', // ← ini bikin label tebal
                                        colors: '#000' // (opsional) biar hitam pekat
                                    }
                                }
                            },
                            tooltip: {
                                y: {
                                    formatter: function(val) {
                                        return val + " orang";
                                    }
                                }
                            }
                        };

                        var chart = new ApexCharts(document.querySelector("#grafik-karyawan"), options);
                        chart.render();
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->
<?= $this->endSection() ?>