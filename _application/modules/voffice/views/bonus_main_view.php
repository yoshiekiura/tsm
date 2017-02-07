<br />
<table class="table table-striped table-hover" style="margin:0;">
    <thead>
        <tr>
            <th><h4 style="padding:0; margin:0;">&nbsp;</h4></th>
            <th width="20%" style="text-align:right;"><h4 style="padding:0; margin:0;">Diperoleh (Rp)</h4></th>
            <th width="20%" style="text-align:right;"><h4 style="padding:0; margin:0;">Dibayarkan (Rp)</h4></th>
            <th width="20%" style="text-align:right;"><h4 style="padding:0; margin:0;">Saldo (Rp)</h4></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total_bonus_in = $total_bonus_out = $total_bonus_saldo = 0;
        foreach($arr_active_bonus as $bonus_item) {
            $arr_bonus_value = $this->mlm_function->get_selected_bonus($bonus_item['name'], $this->session->userdata('network_id'));
            $total_bonus_in += $arr_bonus_value['bonus_in'];
            $total_bonus_out += $arr_bonus_value['bonus_out'];
            $total_bonus_saldo += $arr_bonus_value['bonus_saldo'];
        ?>
        <tr>
            <td><h5 style="padding:0; margin:0;"><?php echo $bonus_item['label']; ?></h5></td>
            <td style="text-align:right;"><h5 style="padding:0; margin:0;"><?php echo $this->function_lib->set_number_format($arr_bonus_value['bonus_in']); ?></h5></td>
            <td style="text-align:right;"><h5 style="padding:0; margin:0;"><?php echo $this->function_lib->set_number_format($arr_bonus_value['bonus_out']); ?></h5></td>
            <td style="text-align:right;"><h5 style="padding:0; margin:0;"><?php echo $this->function_lib->set_number_format($arr_bonus_value['bonus_saldo']); ?></h5></td>
        </tr>
        <?php
        }
        ?>
        <tr class="success">
            <th><h4 style="padding:0; margin:0;">TOTAL</h4></th>
            <th style="text-align:right;"><h4 style="padding:0; margin:0;"><?php echo $this->function_lib->set_number_format($total_bonus_in); ?></h4></th>
            <th style="text-align:right;"><h4 style="padding:0; margin:0;"><?php echo $this->function_lib->set_number_format($total_bonus_out); ?></h4></th>
            <th style="text-align:right;"><h4 style="padding:0; margin:0;"><?php echo $this->function_lib->set_number_format($total_bonus_saldo); ?></h4></th>
        </tr>
    </tbody>
</table>