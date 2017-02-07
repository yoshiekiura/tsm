<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Detail Transfer</title>
        <style>
            @media print { .notPrinted { display: none; } }

            body, th, td {
                font-family:tahoma, verdana, courier new;
                font-size:9pt;
            }

            small {
                font-size:8pt;
            }

            th, td {
                font-size:9pt;
            }

            .table-id {
                padding:5px 0;
            }

            .table-id td {
                padding:2px 0 2px 0;
                font-size:9pt;
            }

            .table-print {
                border:1px solid #aaa;
                border-right:none;
                border-top:none;
                border-collapse:collapse;
            }

            .table-print th {
                height:25px;
                border-right:1px solid #aaa;
                border-top:1px solid #aaa;
                text-align:center;
                font-weight:normal;
                background:#f0f0f0;
            }

            .table-print td {
                border-right:1px solid #aaa;
                border-top:1px solid #aaa;
                padding:3px 10px;
            }

            .hr11 {
                height:2px;
                border-top:1px solid #aaa;
                border-bottom:1px solid #aaa;
            }
            
            .status-pending {
                
            }
            
            .status-success {
                color:#27A516;
            }
            
            .status-failed {
                color:#dd0000;
            }

            a {
                color:#ccc;
                font-size:9pt;
            }
        </style>
    </head>
    <body>
        <h2>BONUS STATEMENT</h2>
        <?php
        if (isset($query) && isset($query_detail) && $query->num_rows() > 0 && $query_detail->num_rows() > 0) {
            $row = array_merge($query->row_array(), $query_detail->row_array());
            $arr_transfer_category = $this->mlm_function->get_arr_transfer_category();
            switch($row['bonus_transfer_status']) {
                case "failed":
                    $bonus_transfer_status_label = 'GAGAL';
                    break;
                
                case "success":
                    $bonus_transfer_status_label = 'SUKSES';
                    break;
                
                default:
                    $bonus_transfer_status_label = 'PENDING';
                    break;
            }
            ?>
            <div class="hr11"></div>
            <table width="100%" class="table-id">
                <tr>
                    <td width="50%">
                        <table>
                            <tr><td width="100">Kode Transfer</td><td width="15" align="center">:</td><td><?php echo $row['bonus_transfer_code']; ?></td></tr>
                            <tr><td>Periode</td><td align="center">:</td><td><?php echo convert_datetime($row['bonus_transfer_datetime'], 'id'); ?></td></tr>
                            <tr><td>Kategori</td><td align="center">:</td><td><?php echo strtoupper($arr_transfer_category[$row['bonus_transfer_category']]); ?></td></tr>
                            <tr><td>Status Transfer</td><td align="center">:</td><td class="status-<?php echo $row['bonus_transfer_status']; ?>"><?php echo $bonus_transfer_status_label; ?></td></tr>
                            <tr><td>Keterangan</td><td align="center">:</td><td><?php echo $row['bonus_transfer_note']; ?></td></tr>
                        </table>
                    </td>
                    <td width="50%" align="right">
                        <table>
                            <tr><td>Kode Member</td><td width="15" align="center">:</td><td><?php echo $this->session->userdata('network_code'); ?></td></tr>
                            <tr><td>Nama Member</td><td align="center">:</td><td><?php echo $this->session->userdata('member_name'); ?></td></tr>
                            <tr><td>No. Handphone</td><td align="center">:</td><td><?php echo $row['bonus_transfer_mobilephone']; ?></td></tr>
                            <tr><td>Nama Bank</td><td align="center">:</td><td><?php echo $row['bonus_transfer_bank_name']; ?></td></tr>
                            <tr><td>No. Rekening</td><td align="center">:</td><td><?php echo $row['bonus_transfer_bank_account_no']; ?></td></tr>
                        </table>
                    </td>
                </tr>
            </table>
            
            <table width="100%" class="table-print" border="0" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>KETERANGAN</th>
                        <th width="25%">NILAI (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($arr_bonus as $bonus_item) {
                    ?>
                    <tr>
                        <td><?php echo $this->mlm_function->get_bonus_label($bonus_item); ?></td>
                        <td style="text-align:right;"><?php echo $this->function_lib->set_number_format($row['bonus_transfer_detail_' . $bonus_item]); ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                    <tr valign="top">
                        <td align="right">Total Bonus</td>
                        <td align="right"><?php echo $this->function_lib->set_number_format($row['bonus_transfer_total_bonus']); ?></td>
                    </tr>
                    <tr valign="top">
                        <td align="right"><font color="#dd0000">Biaya Admnistrasi <?php echo ($row['bonus_transfer_adm_charge_percent'] > 0) ? '(' . $row['bonus_transfer_adm_charge_percent'] . ' %)' : ''; ?></font></td>
                        <td align="right"><font color="#dd0000"><?php echo $this->function_lib->set_number_format($row['bonus_transfer_adm_charge']); ?></font></td>
                    </tr>
                    <tr valign="top">
                        <td align="right">Total Transfer</td>
                        <td align="right" bgcolor="#fafafa"><?php echo $this->function_lib->set_number_format($row['bonus_transfer_nett']); ?></td>
                    </tr>
                </tbody>
            </table>
            <br />
            <center><a href="javascript:print()" class="notPrinted">print</a></center>
            <script>window.print();</script>
            <?php
        } else {
            echo '<div class="error alert alert-danger"><p>Maaf, data tidak tersedia.</p></div>';
        }
        ?>
    </body>
</html>