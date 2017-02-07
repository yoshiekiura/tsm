<h2>Report Penggunaan Serial</h2>
<br>
<div style="float:left;" class="btn-group">
    <button onclick="window.location.href='<?php echo base_url() . 'backend/report/ch_serial/show/harian/'; ?>'" class="btn btn-primary"><i class="icon-money"></i>&nbsp; Harian</button>
    <button onclick="window.location.href = '<?php echo base_url() . 'backend/report/ch_serial/show/bulanan/'; ?>'" class="btn btn-primary"><i class="icon-money"></i>&nbsp; Bulanan</button>
    <button onclick="window.location.href = '<?php echo base_url() . 'backend/report/ch_serial/show/tahunan/'; ?>'" class="btn btn-primary"><i class="icon-money"></i>&nbsp; Tahunan</button>
</div>
<div class="clearfix"></div>
<br>
<form name="frm_chart" method="post" action="" class="form-horizontal form-bordered">
    <div style="width: 100%; display: inline-block;">
        <div style="padding-left: 0;" class="form-group input-group col-md-4">
            <?php
            if($this->uri->segment(5)=='bulanan'){
                echo '<select name="date_start" class="form-control">';
                for($y=date("Y");$y>=2011;$y--){
                    $selected = (substr($this->uri->segment(6,date("Y")),0 ,4)==$y)?'selected':'';
                    echo '<option value="'.$y.'-01-01" '.$selected.'>'.$y.'</option>';
                }
                echo '</select>';
                echo '<span class="input-group-btn"><button type="submit" class="btn btn-primary" name="cari" value="Cari"><i class="icon-search"></i></button></span>';
            } else if(!$this->uri->segment(5) || $this->uri->segment(5)=='harian'){
                echo '<input type="text" value="'.$this->uri->segment(6, (date("Y-m-d", strtotime('-6 day',strtotime(date("Y-m-d")))))).'" name="date_start" id="datepicker" class="form-control">';
                echo '<span class="input-group-btn"><button type="submit" class="btn btn-primary" name="cari" value="Cari"><i class="icon-search"></i></button></span>';
            }
            ?>
        </div>
    </div>
</form>
<script>
    $(function() {
            $("#datepicker").datepicker();
    });
</script>
<script type="text/javascript">
$(function() {
    var chart = new Highcharts.Chart({
        chart: {
            renderTo: "penggunaan", type: 'column',width: 542, height: 250, borderWidth: 1,
            backgroundColor: {
                linearGradient: [0, 500, 0, 0], stops: [[0, "rgb(255, 255, 255)"], [1, "rgb(190, 200, 255)"]]
            }
        },
        colors: ["#ED561B", "#50B432", "#270BB6", "#C11000", "#FFF30F", "#CC0099", "#0A899E", "#422400"],
        credits: {
            enabled: false
        },
        title: {
            text: 'Penggunaan Kartu Aktivasi'
        },
        legend: {
            enabled: false
        },
        xAxis: {
            categories:<?php echo json_encode($grafik['penggunaan']['categories']);?>,
            labels: {
                rotation: -15,
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
            column: {
                pointPadding: 0.2, borderWidth: 1
            }
        },
        series: <?php echo json_encode($grafik['penggunaan']['series']);?>
    });
});

$(function() {
    var chart = new Highcharts.Chart({
        chart: {
            renderTo: "aktivasi", type: 'column',width: 542, height: 250, borderWidth: 1,
            backgroundColor: {
                linearGradient: [0, 500, 0, 0], stops: [[0, "rgb(255, 255, 255)"], [1, "rgb(190, 200, 255)"]]
            }
        },
        colors: ["#ED561B", "#50B432", "#270BB6", "#C11000", "#FFF30F", "#CC0099", "#0A899E", "#422400"],
        credits: {
            enabled: false
        },
        title: {
            text: 'Aktivasi Kartu'
        },
        legend: {
            enabled: false
        },
        xAxis: {
            categories:<?php echo json_encode($grafik['aktivasi']['categories']);?>,
            labels: {
                rotation: -15,
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
            column: {
                pointPadding: 0.2, borderWidth: 1
            }
        },
        series: <?php echo json_encode($grafik['aktivasi']['series']);?>
    });
});

$(function() {
    var chart = new Highcharts.Chart({
        chart: {
            renderTo: "jual_aktif", type: 'column',width: 542, height: 250, borderWidth: 1,
            backgroundColor: {
                linearGradient: [0, 500, 0, 0], stops: [[0, "rgb(255, 255, 255)"], [1, "rgb(190, 200, 255)"]]
            }
        },
        colors: ["#ED561B", "#50B432", "#270BB6", "#C11000", "#FFF30F", "#CC0099", "#0A899E", "#422400"],
        credits: {
            enabled: false
        },
        title: {
            text: 'Penjualan Kartu Aktif'
        },
        legend: {
            enabled: false
        },
        xAxis: {
            categories:<?php echo json_encode($grafik['jual_aktif']['categories']);?>,
            labels: {
                rotation: -15,
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
            column: {
                pointPadding: 0.2, borderWidth: 1
            }
        },
        series: <?php echo json_encode($grafik['jual_aktif']['series']);?>
    });
});

$(function() {
    var chart = new Highcharts.Chart({
        chart: {
            renderTo: "jual_pasif", type: 'column',width: 542, height: 250, borderWidth: 1,
            backgroundColor: {
                linearGradient: [0, 500, 0, 0], stops: [[0, "rgb(255, 255, 255)"], [1, "rgb(190, 200, 255)"]]
            }
        },
        colors: ["#ED561B", "#50B432", "#270BB6", "#C11000", "#FFF30F", "#CC0099", "#0A899E", "#422400"],
        credits: {
            enabled: false
        },
        title: {
            text: 'Penjualan Kartu Pasif'
        },
        legend: {
            enabled: false
        },
        xAxis: {
            categories:<?php echo json_encode($grafik['jual_pasif']['categories']);?>,
            labels: {
                rotation: -15,
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
            column: {
                pointPadding: 0.2, borderWidth: 1
            }
        },
        series: <?php echo json_encode($grafik['jual_pasif']['series']);?>
    });
});
</script>
<div id="penggunaan" style="width: 547px; float: left;"></div>
<div id="aktivasi" style="width: 547px; float: right;  padding-left: 5px;"></div>
<div style="clear: both; height: 10px;"></div>
<div id="jual_aktif" style="width: 547px; float: left;"></div>
<div id="jual_pasif" style="width: 547px; float: right;  padding-left: 5px;"></div>
<div style="clear: both;"></div>
<p>Page rendered in <strong>{elapsed_time}</strong> seconds</p>