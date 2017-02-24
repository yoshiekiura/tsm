<div class="row">
    <div class="col-md-6">
        <!-- performance -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-danger box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Status Jaringan</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <table class="table table-condensed table-striped">
                            <tr>
                                <td width="25%">&nbsp;&nbsp;<strong>No. Anggota</strong></td>
                                <td width="1%">:</td>
                                <td><?php echo strtoupper($network_code); ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;<strong>Nama</strong></td>
                                <td>:</td>
                                <td><?php echo strtoupper($member_name); ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;<strong>Sponsor</strong></td>
                                <td>:</td>
                                <td><?php echo '(' . $sponsor_code . ') ' . strtoupper($sponsor_name); ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;<strong>Upline</strong></td>
                                <td>:</td>
                                <td><?php echo '(' . $upline_code . ') ' . strtoupper($upline_name); ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;<strong>Position</strong></td>
                                <td>:</td>
                                <td><?php echo $member_position; ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;<strong>Tanggal Join</strong></td>
                                <td>:</td>
                                <td><?php echo date_converter($member_join_datetime, 'd F Y'); ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;<strong>Sponsoring</strong></td>
                                <td>:</td>
                                <td><?php echo $this->function_lib->set_number_format($sponsoring_count); ?> mitra</td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;<strong>Jumlah Jaringan</strong></td>
                                <td>:</td>
                                <td>
                                    <?php echo $this->function_lib->set_number_format($arr_node['left']); ?> kiri, <?php echo $this->function_lib->set_number_format($arr_node['right']); ?> kanan
                                    <span class="pull-right"><a href="<?php echo base_url('voffice/network/node'); ?>">[LIHAT DETAIL]</a></span>
                                </td>
                            </tr>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>

        <!-- komisi -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Status Komisi <small><strong><a href="<?php echo base_url() . 'voffice/bonus/log'; ?>">[LIHAT DETAIL BONUS]</a></strong></small></h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <table class="table table-condensed">
                            <?php
                            if ($query_bonus_log->num_rows() > 0) {
                                $row_bonus_log = $query_bonus_log->row();
                                $bonus_log_total = $row_bonus_log->bonus_log_total;
                                $i = 0;
                                foreach ($arr_active_bonus as $bonus_item) {
                                    $style = ($i % 2 == 0) ? '' : 'background-color:#eee;';
                                    $field_bonus_log = "bonus_log_" . $bonus_item['name'];
                                    echo '<tr style="' . $style . '">';
                                    echo '<td>&nbsp;&nbsp;' . $bonus_item['label'] . '</td>';
                                    echo '<td align="right">Rp ' . $this->function_lib->set_number_format($row_bonus_log->$field_bonus_log) . ',-&nbsp;&nbsp;</td>';
                                    echo '</tr>';
                                    $i++;
                                }
                            } else {
                                $bonus_log_total = 0;
                            }
                            ?>
                            <tr style="background-color:#ddd;">
                                <td>&nbsp;&nbsp;<strong>TOTAL INCOME</strong></td>
                                <td align="right"><strong>Rp <?php echo $this->function_lib->set_number_format($bonus_log_total); ?>,-&nbsp;&nbsp;</strong></td>
                            </tr>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>

        <!-- komisi hari ini-->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Potensi Komisi Hari Ini <?php echo convert_date(date("Y-m-d"), 'id'); ?> </h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <table class="table table-condensed table-striped">
                            <?php
                                $bonus_daily_total = 0;
                                foreach ($arr_daily_bonus as $bonus_item) {
                                    echo '<td>&nbsp;&nbsp;' . $bonus_item['label'] . '</td>';
                                    echo '<td align="right">Rp ' . $this->function_lib->set_number_format($bonus_item['value']) . ',-&nbsp;&nbsp;</td>';
                                    echo '</tr>';

                                    $bonus_daily_total += $bonus_item['value'];
                                }
                            
                            ?>
                            <tr style="background-color:#ddd;">
                                <td>&nbsp;&nbsp;<strong>TOTAL INCOME</strong></td>
                                <td align="right"><strong>Rp <?php echo $this->function_lib->set_number_format($bonus_daily_total); ?>,-&nbsp;&nbsp;</strong></td>
                            </tr>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <!-- info jaringan hari ini-->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Info Jaringan Hari Ini <?php echo convert_date(date("Y-m-d"), 'id'); ?> </h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <table class="table table-condensed table-striped">
                            <tr>
                                <td width="30%">&nbsp;&nbsp;<strong>Sponsorisasi</strong></td>
                                <td width="1%">:</td>
                                <td><?php echo $sponsoring_count_today; ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;<strong>Penambahan Jaringan</strong></td>
                                <td>:</td>
                                <td>
                                    <?php echo $this->function_lib->set_number_format($arr_node_today['left']); ?> kiri, <?php echo $this->function_lib->set_number_format($arr_node_today['right']); ?> kanan
                                    <span class="pull-right"><a href="<?php echo base_url('voffice/network/node'); ?>">[LIHAT DETAIL]</a></span>
                                </td>
                            </tr>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>

        <!-- new member -->
        <div class="row">
            <div class="col-md-12">
                <div id="user_info" class="box box-info box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Mitra Baru Bulan <?php echo convert_month($month, 'id'); ?> <?php echo $year; ?></h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body" style="">
                        <?php
                        if ($query_downline->num_rows() > 0) {
                            $i = 1;
                            echo '<ul>';
                            foreach ($query_downline->result() as $row_downline) {
                                if ($row_downline->member_image != '' && file_exists(_dir_member . $row_downline->member_image)) {
                                    $downline_image = $row_downline->member_image;
                                } else {
                                    $downline_image = '_default.jpg';
                                }
                                echo '<li>';
                                echo '<div class="row">';
                                echo '<div class="col-md-3">';
                                echo '<div align="center">';
                                echo '<img class="img-circle img-thumbnail" src="' . base_url() . 'media/' . _dir_member . '75/75/' . $downline_image . '" alt="' . strtoupper(stripslashes($row_downline->member_name)) . '" />';
                                echo '<span class="badge">' . $i . '</span>';
                                echo '</div>';
                                echo '</div>';
                                echo '<div class="col-md-9">';
                                echo '<span><strong>(' . $row_downline->network_code . ') ' . strtoupper(stripslashes($row_downline->member_name)) . '</strong></span>';
                                echo '<span><strong>Tanggal</strong>: ' . convert_date($row_downline->member_join_datetime) . '</span>';
                                echo '<span><strong>Sponsor</strong>: (' . $row_downline->sponsor_network_code . ') ' . strtoupper(stripslashes($row_downline->sponsor_member_name)) . '</span>';
                                echo '</div>';
                                echo '</div>';
                                echo '</li>';
                                $i++;
                            }
                            echo '</ul>';
                        } else {
                            echo '<h3 style="text-align:center; color:#ccc;">Belum ada Mitra Baru</h3>';
                        }
                        ?>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </div>
</div>






<?php
if ($query_network_group->num_rows() > 0) {
    $row_network_group = $query_network_group->row();
    ?>
    <h3>Informasi</h3>
    <p>Anda telah di daftarkan sebagai Anggota Grup dari:</p>
    <table class="table table-striped table-hover">
        <tr>
            <td width="120">Kode Member</td>
            <td><?php echo $row_network_group->network_code; ?></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td><?php echo $row_network_group->member_name; ?></td>
        </tr>
        <tr>
            <td>No. Handphone</td>
            <td><?php echo $row_network_group->member_mobilephone; ?></td>
        </tr>
    </table>
    <p>Jika anda melakukan <strong>Konfirmasi</strong>, maka member tersebut dapat leluasa mengakses akun anda.</p>
    <p><a class="btn btn-success" href="<?php echo base_url(); ?>voffice/systems/network_group_approve">Konfirmasi</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" href="<?php echo base_url(); ?>voffice/systems/network_group_deny">Tolak</a></p>
    <?php
}
?>