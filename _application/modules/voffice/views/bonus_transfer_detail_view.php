<h2>Detail Transfer</h2>
<?php
if (isset($query) && isset($query_detail) && $query->num_rows() > 0 && $query_detail->num_rows() > 0) {
    $row = array_merge($query->row_array(), $query_detail->row_array());
    ?>
    <br />
    <table class="table table-striped table-hover" style="margin:0;">
        <thead>
            <tr>
                <th><h4 style="padding:0; margin:0;">Keterangan</h4></th>
                <th width="20%" style="text-align:right;"><h4 style="padding:0; margin:0;">Nilai (Rp)</h4></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($arr_bonus as $bonus_item) {
            ?>
            <tr>
                <td><h5 style="padding:0; margin:0;"><?php echo $this->mlm_function->get_bonus_label($bonus_item); ?></h5></td>
                <td style="text-align:right;"><h5 style="padding:0; margin:0;"><?php echo $this->function_lib->set_number_format($row['bonus_transfer_detail_' . $bonus_item]); ?></h5></td>
            </tr>
            <?php
            }
            ?>
            <tr>
                <th><h4 style="padding:0; margin:0;">Total Bonus</h4></th>
                <th style="text-align:right;"><h4 style="padding:0; margin:0;"><?php echo $this->function_lib->set_number_format($row['bonus_transfer_total_bonus']); ?></h4></th>
            </tr>
            <tr>
                <th><h4 style="padding:0; margin:0;">Biaya Administrasi <?php echo ($row['bonus_transfer_adm_charge_percent'] > 0) ? '(' . $row['bonus_transfer_adm_charge_percent'] . ' %)' : ''; ?></h4></th>
                <th style="text-align:right;"><h4 style="padding:0; margin:0;"><?php echo $this->function_lib->set_number_format($row['bonus_transfer_adm_charge']); ?></h4></th>
            </tr>
            <tr class="success">
                <th><h4 style="padding:0; margin:0;">Total Transfer</h4></th>
                <th style="text-align:right;"><h4 style="padding:0; margin:0;"><?php echo $this->function_lib->set_number_format($row['bonus_transfer_nett']); ?></h4></th>
            </tr>
        </tbody>
    </table>
    <?php
} else {
    echo '<div class="error alert alert-danger"><p>Maaf, data tidak tersedia.</p></div>';
}
?>