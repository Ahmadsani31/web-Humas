<?= $this->extend('_template/_app') ?>
<?= $this->section('contentCSS') ?>

<?= $this->endSection() ?>
<?= $this->section('contentBody') ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Kerma</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $Kerma; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-handshake fa-2x text-gray-300" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Mitra</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $Mitra; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">

                <!-- Card Body -->
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="myAreaChart"></div>
                    </figure>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">

                <!-- Card Body -->
                <div class="card-body">
                    <figure class="highcharts-figure">
                        <div id="myPieChart"></div>
                    </figure>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
</div>
<?= $this->endSection() ?>
<?= $this->section('contentJS') ?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/modules/variable-pie.js"></script>
<script>
    // Shorthand for $( document ).ready()
    $(function() {
        $.ajax({
            url: '<?= base_url('dashboard/grafik'); ?>',
            dataType: 'JSON',
            type: 'GET',
            success: function(data, textStatus, jQxhr) {
                // console.log(data.Tahun);

                Highcharts.chart('myAreaChart', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Kerja Sama Institut Teknologi Padang'
                    },
                    subtitle: {
                        text: 'Humas'
                    },
                    xAxis: {
                        categories: data.bar.Tahun,
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Jumlah kerja sama'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:1f} </b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [{
                        name: 'MoU',
                        data: data.bar.MoU

                    }, {
                        name: 'MoA',
                        data: data.bar.MoA

                    }, {
                        name: 'IA',
                        data: data.bar.MaI

                    }]
                });
                Highcharts.chart('myPieChart', {
                    chart: {
                        type: 'variablepie'
                    },
                    title: {
                        text: 'Document Kerma',
                        align: 'left'
                    },
                    tooltip: {
                        headerFormat: '',
                        pointFormat: '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
                            'Jumlah kerma: <b>{point.z}</b><br/>'
                    },
                    plotOptions: {
                        variablepie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true
                            },
                            showInLegend: true
                        }
                    },
                    series: [{
                        minPointSize: 10,
                        innerSize: '20%',
                        zMin: 0,
                        name: 'countries',
                        data: [{
                            name: 'MoU',
                            y: (data.pie.MoU * 10),
                            z: data.pie.MoU
                        }, {
                            name: 'MoA',
                            y: (data.pie.MoA * 10),
                            z: data.pie.MoA
                        }, {
                            name: 'IA',
                            y: (data.pie.MaI * 10),
                            z: data.pie.MaI,
                        }]
                    }]
                });

            },
            error: function(jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });




    });


    // Data retrieved from https://worldpopulationreview.com/country-rankings/countries-by-density
</script>
<?= $this->endSection() ?>