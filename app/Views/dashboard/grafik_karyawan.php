<?= $this->extend('layout/index') ?>
<?= $this->section('content') ?>

<!-- Start Content -->
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
    <!-- Grafik -->
    <style>
        #grafik-karyawan-wrapper {
            overflow-x: auto;
        }

        #grafik-karyawan {
            min-width: 1800px;
        }
    </style>
    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
                    <div style="overflow-x: auto; width: 100%;">
                        <div style="min-width: 2400px;"> <!-- ini ngebantu spacing antar bulan -->
                            <div id="grafik-karyawan"></div>
                        </div>
                    </div>

                    <script>
                        var options = {
                            chart: {
                                type: 'bar',
                                height: 500,
                                stacked: false,
                                toolbar: {
                                    show: true
                                }
                            },
                            series: <?= $series ?>,
                            colors: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6f42c1', '#17a2b8', '#fd7e14', '#20c997', '#6610f2', '#e83e8c', '#343a40'],
                            xaxis: {
                                categories: <?= $categories ?>,
                                labels: {
                                    rotate: -45,
                                    style: {
                                        fontSize: '12px',
                                        fontWeight: 'bold',
                                        colors: '#000'
                                    }
                                },
                                title: {
                                    text: 'Bulan',
                                    style: {
                                        fontWeight: 600
                                    }
                                }
                            },
                            yaxis: {
                                title: {
                                    text: 'Jumlah Karyawan',
                                    style: {
                                        fontWeight: 600
                                    }
                                }
                            },
                            tooltip: {
                                shared: true,
                                intersect: false,
                                y: {
                                    formatter: function(val) {
                                        return val + " orang";
                                    }
                                }
                            },
                            legend: {
                                position: 'top',
                                horizontalAlign: 'center',
                                floating: false,
                                offsetY: 5,
                                itemMargin: {
                                    horizontal: 10,
                                    vertical: 5
                                },
                                labels: {
                                    useSeriesColors: false
                                },
                                markers: {
                                    width: 10,
                                    height: 10
                                }
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                    columnWidth: '90%', // jangan 100%, biar ada jarak antar bulan
                                    endingShape: 'rounded',
                                    barHeight: '100%'
                                }
                            },
                            dataLabels: {
                                enabled: true,
                                offsetY: -12, // semakin negatif, semakin jauh dari batang bar
                                style: {
                                    fontSize: '10px',
                                    colors: ['#000']
                                }
                            },
                            title: {
                                text: 'Jumlah Karyawan per Divisi per Bulan',
                                align: 'center',
                                style: {
                                    fontSize: '16px',
                                    fontWeight: 'bold'
                                }
                            },
                            subtitle: {
                                text: 'Tahun <?= $year ?>',
                                align: 'center',
                                style: {
                                    fontSize: '14px'
                                }
                            },
                            responsive: [{
                                breakpoint: 768,
                                options: {
                                    chart: {
                                        height: 600
                                    },
                                    legend: {
                                        position: 'bottom'
                                    }
                                }
                            }]
                        };

                        var chart = new ApexCharts(document.querySelector("#grafik-karyawan"), options);
                        chart.render();
                    </script>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>