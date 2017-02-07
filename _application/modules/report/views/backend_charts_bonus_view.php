<h2>Report Payout</h2>
<br>
<div style="float:left;" class="btn-group">
    <button onclick="window.location.href='<?php echo base_url() . 'backend/report/ch_bonus/show/harian/'; ?>'" class="btn btn-primary"><i class="icon-money"></i>&nbsp; Harian</button>
    <button onclick="window.location.href = '<?php echo base_url() . 'backend/report/ch_bonus/show/bulanan/'; ?>'" class="btn btn-primary"><i class="icon-money"></i>&nbsp; Bulanan</button>
    <button onclick="window.location.href = '<?php echo base_url() . 'backend/report/ch_bonus/show/tahunan/'; ?>'" class="btn btn-primary"><i class="icon-money"></i>&nbsp; Tahunan</button>
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
            renderTo: "total_payout", type: 'pie',width: 442, height: 350, borderWidth: 1,
            backgroundColor: {
                linearGradient: [0, 500, 0, 0], stops: [[0, "rgb(255, 255, 255)"], [1, "rgb(190, 200, 255)"]]
            }
        },
        colors: ["#ED561B", "#50B432", "#270BB6", "#C11000", "#FFF30F", "#CC0099", "#0A899E", "#422400"],
        credits: {
            enabled: false
        },
        title: {
            text: 'Total Bonus Member'
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
        series: <?php echo json_encode($grafik['total_payout']['series']);?>
    });
});

$(function() {
    var chart = new Highcharts.Chart({
        chart: {
            renderTo: "profit", type: 'bar',width: 442, height: 350, borderWidth: 1,
            backgroundColor: {
                linearGradient: [0, 500, 0, 0], stops: [[0, "rgb(255, 255, 255)"], [1, "rgb(190, 200, 255)"]]
            }
        },
        colors: ["#ED561B", "#50B432", "#270BB6", "#C11000", "#FFF30F", "#CC0099", "#0A899E", "#422400"],
        credits: {
            enabled: false
        },
        title: {
            text: 'Profit'
        },
        legend: {
            enabled: false
        },
        xAxis: [{
            categories:<?php echo json_encode($grafik['profit']['categories']);?>,
            labels: {
                step: 1
        }}, 
        { // mirror axis on right side
            opposite: true,
            reversed: false,
            linkedTo: 0,
            labels: {
                step: 1
            }
        }],
        yAxis: {
            title: {
                text: 'Jumlah'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0">Rp {point.y}</td></tr>',
            footerFormat: '</table>', shared: true, useHTML: true
        },
        plotOptions: {
            series: {
                stacking: 'normal'
            }
        },
        series: <?php echo json_encode($grafik['profit']['series']);?>
    });
});

$(function() {
    var chart = new Highcharts.Chart({
        chart: {
            renderTo: "total_payout_day", type: 'bar',width: 190, height: 350, borderWidth: 1,
            backgroundColor: {
                linearGradient: [0, 500, 0, 0], stops: [[0, "rgb(255, 255, 255)"], [1, "rgb(190, 200, 255)"]]
            }
        },
        colors: ["#ED561B", "#50B432", "#270BB6", "#C11000", "#FFF30F", "#CC0099", "#0A899E", "#422400"],
        credits: {
            enabled: false
        },
        title: {
            text: 'Total Bonus'
        },
        legend: {
            enabled: false
        },
        xAxis: [{
            categories:<?php echo json_encode($grafik['total_payout_day']['categories']);?>,
            reversed: false
        }],
        yAxis: {
            title: {
                text: 'Jumlah'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="padding:0">Rp {point.y}</td></tr>',
            footerFormat: '</table>', shared: true, useHTML: true
        },
        plotOptions: {
            series: {
                stacking: 'normal'
            }
        },
        series: <?php echo json_encode($grafik['total_payout_day']['series']);?>
    });
});

$(function() {
    var chart = new Highcharts.Chart({
        chart: {
            renderTo: "payout", type: 'line',width: 542, height: 250, borderWidth: 1,
            backgroundColor: {
                linearGradient: [0, 500, 0, 0], stops: [[0, "rgb(255, 255, 255)"], [1, "rgb(190, 200, 255)"]]
            }
        },
        colors: ["#ED561B", "#50B432", "#270BB6", "#C11000", "#FFF30F", "#CC0099", "#0A899E", "#422400"],
        credits: {
            enabled: false
        },
        title: {
            text: 'Bonus Member'
        },
        legend: {
            padding: 1
        },
        xAxis: {
            categories:<?php echo json_encode($grafik['payout']['categories']);?>,
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
                    '<td style="padding:0">Rp {point.y}</td></tr>',
            footerFormat: '</table>', shared: true, useHTML: true
        },
        plotOptions: {
            series: {
                lineWidth: 1,
                marker: {
                    enabled: false
                }}
        },
        series: <?php echo json_encode($grafik['payout']['series']);?>
    });
});

$(function() {
    var chart = new Highcharts.Chart({
        chart: {
            renderTo: "transfer", type: 'line',width: 542, height: 250, borderWidth: 1,
            backgroundColor: {
                linearGradient: [0, 500, 0, 0], stops: [[0, "rgb(255, 255, 255)"], [1, "rgb(190, 200, 255)"]]
            }
        },
        colors: ["#ED561B", "#50B432", "#270BB6", "#C11000", "#FFF30F", "#CC0099", "#0A899E", "#422400"],
        credits: {
            enabled: false
        },
        title: {
            text: 'Transfer Bonus'
        },
        legend: {
            padding: 1
        },
        xAxis: {
            categories:<?php echo json_encode($grafik['transfer']['categories']);?>,
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
                    '<td style="padding:0">Rp {point.y}</td></tr>',
            footerFormat: '</table>', shared: true, useHTML: true
        },
        plotOptions: {
            series: {
                lineWidth: 1,
                marker: {
                    enabled: false
                }}
        },
        series: <?php echo json_encode($grafik['transfer']['series']);?>
    });
});
</script>
<ul style="list-style: none; display: block; padding: 0;">
    <li style="float: left; margin: 0 5px 10px 0;"><div id="profit" style="width: 447px;"></div></li>
    <li style="float: left; margin: 0 5px 10px 0;"><div id="total_payout" style="width: 447px;"></div></li>
    <li style=" margin-bottom: 10px;"><div id="total_payout_day" style="width: 195px;"></div></li>
    <li style="float: left; margin-right: 5px;"><div id="payout" style="width: 547px;"></div></li>
    <li><div id="transfer" style="width: 547px;"></div></li>
</ul>
<p>Page rendered in <strong>{elapsed_time}</strong> seconds</p>