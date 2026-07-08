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
                    <h5>Report Order Catering</h5>
                    <div id="chart"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ApexCharts CDN -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    const options = {
        chart: {
            type: 'bar',
            height: 350,
            stacked: false,
            toolbar: {
                show: true
            },
        },
        series: <?= json_encode($series) ?>,
        xaxis: {
            categories: <?= json_encode($categories) ?>,
        },
        colors: ['#4caf50', '#ff9800', '#2196f3', '#f44336', '#9c27b0'],
        legend: {
            position: 'top',
            horizontalAlign: 'left'
        },
        plotOptions: {
            bar: {
                horizontal: false,
                borderRadius: 5
            }
        },
        dataLabels: {
            enabled: false
        }
    };

    const chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>

<?= $this->endSection() ?>