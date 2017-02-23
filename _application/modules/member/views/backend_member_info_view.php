<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Member Info</title>
        <style>
            .qtip-wiki{
                max-width: 600px;
            }
            
            .table-id {
                margin:5px 0 5px 0;
                font-family:tahoma, verdana, courier new;
                font-size:9pt;
            }
            
            .table-id tr {
                vertical-align:top;
            }

            .table-id td {
                padding:3px 3px 3px 3px;
                font-size:9pt;
                line-height:15px;
            }
        </style>
    </head>
    <body>
        <?php
        if ($arr_data) {
            extract($arr_data);
            ?>
            <h4 style="padding:0; margin:0 0 10px 0;"><?php echo $network_code; ?> (<?php echo stripslashes($member_name); ?>)</h4>
            <table width="100%" class="table-id">
                <tr>
                    <td width="110">No. Kontak</td>
                    <td width="5" align="center">:</td>
                    <td><?php echo ($member_mobilephone != '') ? $member_mobilephone : '-'; ?></td>
                </tr>
                <tr>
                    <td>Tgl Gabung</td>
                    <td align="center">:</td>
                    <td><?php echo convert_datetime($member_join_datetime, 'id'); ?></td>
                </tr>
                <tr>
                    <td>Sponsor</td>
                    <td align="center">:</td>
                    <td><?php echo $sponsor_network_code; ?> (<?php echo $sponsor_member_name; ?>)</td>
                </tr>
                <tr>
                    <td>Upline</td>
                    <td align="center">:</td>
                    <td><?php echo $upline_network_code; ?> (<?php echo $upline_member_name; ?>)</td>
                </tr>
                <tr>
                    <td>Sponsoring</td>
                    <td align="center">:</td>
                    <td><?php echo $this->function_lib->set_number_format($sponsoring_count_left); ?> kiri &nbsp;/&nbsp; <?php echo $this->function_lib->set_number_format($sponsoring_count_right); ?> kanan</td>
                </tr>
                <tr>
                    <td>Jumlah Titik</td>
                    <td align="center">:</td>
                    <td><?php echo $this->function_lib->set_number_format($network_total_downline_left); ?> kiri &nbsp;/&nbsp; <?php echo $this->function_lib->set_number_format($network_total_downline_right); ?> kanan</td>
                </tr>
                <tr>
                    <td>Kedalaman Level</td>
                    <td align="center">:</td>
                    <td>Lv <?php echo $this->function_lib->set_number_format($max_level_left); ?> kiri &nbsp;/&nbsp; Lv <?php echo $this->function_lib->set_number_format($max_level_right); ?> kanan</td>
                </tr>
            </table>
            <?php
        } else {
            echo '<div class="error alert alert-danger"><p>Maaf, data tidak tersedia.</p></div>';
        }
        ?>
    </body>
</html>