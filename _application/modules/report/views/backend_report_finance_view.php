<?php 
$total_pendapatan = 0;
$grand_total_payout = 0;
?>
<h2><?php echo $title ?></h2>
<hr>
<?php if ($period == 'monthly'): ?>
    <div class="box">
        <div class="box-title">
            <div class="caption"><i class="icon-search"></i><strong>LAPORAN BULANAN</strong></div>
        </div>
        <div class="box-body form">
            <br>
            <form action="" method="post">
                <div class="form-body">
                    <div class="form-group" >
                        <label class="control-label col-md-3" style="border-left: 0px;text-align: center;"><h4><strong>Periode</strong></h4></label>;
                        <div class="col-md-2" style="border-left: 0px;">
                            <?php echo form_dropdown('month', $month_options, !empty($this->session->flashdata('month')) ? $this->session->flashdata('month') : date_converter($search_date, 'm'), 'class="form-control" width="50" id="month"'); ?>
                        </div>
                        <div class="col-md-2" style="border-left: 0px;">
                            <?php echo form_dropdown('year', $year_options, !empty($this->session->flashdata('year')) ? $this->session->flashdata('year') : date_converter($search_date, 'Y'), 'class="form-control" width="50" id="year" '); ?>
                        </div>
                        <div class="col-md-3" style="border-left: 0px;"><button name="search" type="submit" class="btn btn-success" onclick="showData();"><i class="icon-search" ></i> LIHAT OMSET</button></div>
                    </div>
                </div>
            </form>
            <div class="form-actions fluid"></div>
        </div>
    </div>
<?php endif ?>

<div class="panel panel-primary" id="panel_income">
    <div class="panel-heading">
        <h3 class="panel-title"><strong>PENDAPATAN</strong></h3>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover" style="margin-bottom: 0;">
            <thead>
                <tr>
                    <th class="text-center">Type Serial </th>
                    <th class="text-right">Harga (Rp.) </th>
                    <th class="text-right">Jumlah Aktivasi </th>
                    <th class="text-right">Pendapatan (Rp.)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($serial_type as $row_serial): ?>
                <tr style="font-size:15px;">
                    <td class="text-left"><?php echo $row_serial->serial_type_name ?></td>
                    <td class="text-right"><?php echo $this->function_lib->set_number_format($row_serial->last_price) ?></td>
                    <td class="text-right"><?php echo $this->function_lib->set_number_format($row_serial->count_member_joined) ?></td>
                    <td class="text-right"><?php echo $this->function_lib->set_number_format($row_serial->subtotal) ?></td>
                </tr>
                <?php $total_pendapatan += $row_serial->subtotal ?>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <div class="panel-footer" style="background-color: #49D2CB">
        <div class="row" style="font-size: 16px; font-weight: bold;">
            <div class="col-md-6 text-center"><strong>TOTAL PENDAPATAN</strong></div>
            <div class="col-md-6 text-right"><?php echo $this->function_lib->set_number_format($total_pendapatan) ?></div>
        </div>
    </div>
</div>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><strong>PAYOUT BONUS</strong></h3>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hovered" style="margin-bottom: 0;">
            <thead>
                <tr>
                    <th style="width: 30%;">BONUS</th>
                    <th class="text-right">Jumlah (Rp.)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($arr_bonus as $bonus_item): ?>
                    <tr>
                        <td><?php echo ucfirst($bonus_item['label']) ?></td>
                        <td class="text-right"><?php echo $this->function_lib->set_number_format($bonus_item['total_bonus']) ?></td>
                    </tr>
                <?php $grand_total_payout += $bonus_item['total_bonus'] ?>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <div class="panel-footer" style="background-color: #49D2CB">
        <div class="row" style="font-size: 16px; font-weight: bold;">
            <div class="col-md-6 text-center"><strong>TOTAL PAYOUT BONUS</strong></div>
            <div class="col-md-6 text-right"><?php echo $this->function_lib->set_number_format($grand_total_payout); ?></div>
        </div>
    </div>
</div>

<div class="panel panel-primary">
    <div class="panel-body">
        <div class="row" style="font-size: 17px;">
            <div class="col-md-6"><strong>BALANCE = TOTAL PENDAPATAN - TOTAL PAYOUT</strong></div>
            <div class="col-md-6 text-right"><strong><?php echo $this->function_lib->set_number_format($total_pendapatan - $grand_total_payout); ?></strong></div>
        </div>
    </div>
</div>