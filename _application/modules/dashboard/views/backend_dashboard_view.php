<table class="table table-striped table-hover">
    <tr>
        <td width="150">Login Terakhir Anda</td>
        <td><?php echo convert_datetime($administrator_last_login, 'id'); ?></td>
    </tr>
    <tr>
        <td width="200">Login Terakhir Administrator</td>
        <td><?php echo convert_datetime($administrator_last_last_login, 'id'); ?> oleh <?php echo $administrator_last_name; ?></td>
    </tr>
</table>
<style>
    .panel.panel-warning {
        border: 1px solid #f39c12;
    }
    .panel.panel-warning > .panel-heading {
        color: #ffffff;
        background: #f39c12;
        background-color: #f39c12;
    }
    .panel.panel-success {
        border: 1px solid #00a65a;
    }
    .panel.panel-success > .panel-heading {
        color: #ffffff;
        background: #00a65a;
        background-color: #00a65a;
    }
    .panel.panel-danger {
        border: 1px solid #dd4b39;
    }
    .panel.panel-danger > .panel-heading {
        color: #ffffff;
        background: #dd4b39;
        background-color: #dd4b39;
    }
</style>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Info Serial</h3>
            </div>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td width="30%"><strong>Jumlah Serial</strong></td>
                        <td width="1%">:</td>
                        <td><?php echo $this->function_lib->set_number_format($count_serial) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Jumlah Serial Aktif</strong></td>
                        <td>:</td>
                        <td><?php echo $this->function_lib->set_number_format($count_serial_active) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Jumlah Serial Terpakai</strong></td>
                        <td>:</td>
                        <td><?php echo $this->function_lib->set_number_format($count_serial_used) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="clearfix"></div>

        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title">Info Member</h3>
            </div>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td width="45%"><strong>Jumlah Seluruh Member</strong></td>
                        <td width="1%">:</td>
                        <td><?php echo $this->function_lib->set_number_format($count_member_all) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Member Bulan ini ( <?php echo date_converter($today, 'F Y') ?> )</strong></td>
                        <td>:</td>
                        <td><?php echo $this->function_lib->set_number_format($count_member_monthly) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Member Minggu ini</strong></td>
                        <td>:</td>
                        <td><?php echo $this->function_lib->set_number_format($count_member_weekly) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Member Hari ini ( <?php echo date_converter($today, 'd F Y') ?> )</strong></td>
                        <td>:</td>
                        <td><?php echo $this->function_lib->set_number_format($count_member_daily) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Summary Bonus</h3>
            </div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width="40%">Bonus Item</th>
                        <th class="text-right" width="30%">Bonus Terjadi</th>
                        <th class="text-right" width="30%">Bonus Dibayar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($arr_total_bonus) == 0): ?>
                        <tr>
                            <td colspan="3" class="text-center">Data belum ada.</td>
                        </tr>
                    <?php endif ?>
                    <?php foreach ($arr_total_bonus as $bonus): ?>
                    <tr>
                        <td><strong><?php echo $bonus->report_bonus_item_label; ?></strong></td>
                        <td class="text-right">Rp. <?php echo $this->function_lib->set_number_format($bonus->report_bonus_acc); ?></td>
                        <td class="text-right">Rp. <?php echo $this->function_lib->set_number_format($bonus->report_bonus_paid); ?></td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

        <div class="clearfix"></div>

        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">Kalkulasi Bonus Hari ini</h3>
            </div>
            <table class="table table-striped">
                <tbody>
                    <?php foreach ($arr_daily_bonus_calculation as $bon_name => $bon_item): ?>
                    <tr>
                        <td width="30%"><strong><?php echo $bon_item['label'] ?></strong></td>
                        <td width="1%">:</td>
                        <td class="text-left">Rp. <?php echo $this->function_lib->set_number_format($bon_item['value']) ?></td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        var chart = new Highcharts.Chart({
            chart: {
                renderTo: "member", type: 'line', width: 542, height: 250, borderWidth: 1,
                backgroundColor: {
                    linearGradient: [0, 500, 0, 0], stops: [[0, "rgb(255, 255, 255)"], [1, "rgb(190, 200, 255)"]]
                }
            },
            colors: ["#ED561B", "#50B432", "#270BB6", "#C11000", "#FFF30F", "#CC0099", "#0A899E", "#422400"],
            credits: {
                enabled: false
            },
            title: {
                text: 'Aktivasi Member'
            },
            legend: {
                enabled: false
            },
            xAxis: {
                categories:<?php echo json_encode($grafik['member']['categories']); ?>,
                labels: {
                    rotation: -15
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0">{point.y}</td></tr>',
                footerFormat: '</table>', shared: true, useHTML: true
            },
            plotOptions: {
                series: {
                    lineWidth: 1,
                    marker: {
                        enabled: false
                    }}
                },
                series: <?php echo json_encode($grafik['member']['series']); ?>
            });
    });

    $(function () {
        var chart = new Highcharts.Chart({
            chart: {
                renderTo: "statistik", type: 'column', width: 542, height: 250, borderWidth: 1,
                backgroundColor: {
                    linearGradient: [0, 500, 0, 0], stops: [[0, "rgb(255, 255, 255)"], [1, "rgb(190, 200, 255)"]]
                }
            },
            colors: ["#ED561B", "#50B432", "#270BB6", "#C11000", "#FFF30F", "#CC0099", "#0A899E", "#422400"],
            credits: {
                enabled: false
            },
            title: {
                text: 'Statistik'
            },
            legend: {
                enabled: false
            },
            xAxis: {
                categories:<?php echo json_encode($grafik['statistik']['categories']); ?>
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="padding:0">{point.y}</td></tr>',
                footerFormat: '</table>', shared: true, useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2, borderWidth: 1
                }
            },
            series: <?php echo json_encode($grafik['statistik']['series']); ?>
        });
    });

    $(function () {
        var chart = new Highcharts.Chart({
            chart: {
                renderTo: "bonus", type: 'pie', width: 542, height: 350, borderWidth: 1,
                backgroundColor: {
                    linearGradient: [0, 500, 0, 0], stops: [[0, "rgb(255, 255, 255)"], [1, "rgb(190, 200, 255)"]]
                }
            },
            colors: ["#ED561B", "#50B432", "#270BB6", "#C11000", "#FFF30F", "#CC0099", "#0A899E", "#422400"],
            credits: {
                enabled: false
            },
            title: {
                text: 'Total Bonus 1 Minggu Terakhir'
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px"><b>{point.key}</b></span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">Rp </td>' +
                '<td style="padding:0">{point.y}</td></tr>',
                footerFormat: '</table>', shared: true, useHTML: true
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: <?php echo json_encode($grafik['bonus']['series']); ?>
        });
    });

    $(function () {
        var chart = new Highcharts.Chart({
            chart: {
                renderTo: "transfer", type: 'pie', width: 542, height: 350, borderWidth: 1,
                backgroundColor: {
                    linearGradient: [0, 500, 0, 0], stops: [[0, "rgb(255, 255, 255)"], [1, "rgb(190, 200, 255)"]]
                }
            },
            colors: ["#ED561B", "#50B432", "#270BB6", "#C11000", "#FFF30F", "#CC0099", "#0A899E", "#422400"],
            credits: {
                enabled: false
            },
            title: {
                text: 'Total Transfer 1 Minggu Terakhir'
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px"><b>{point.key}</b></span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">Rp </td>' +
                '<td style="padding:0">{point.y}</td></tr>',
                footerFormat: '</table>', shared: true, useHTML: true
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: <?php echo json_encode($grafik['transfer']['series']); ?>
        });
    });
</script>
<div id="member" style="width: 547px; float: left;"></div>
<div id="statistik" style="width: 547px; float: right;  padding-left: 5px;"></div>
<div style="clear: both; height: 10px;"></div>
<div id="bonus" style="width: 547px; float: left;"></div>
<div id="transfer" style="width: 547px; float: right;  padding-left: 5px;"></div>
<div style="clear: both;"></div>