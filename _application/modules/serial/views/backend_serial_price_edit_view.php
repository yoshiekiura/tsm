<h2>Ubah Harga Serial</h2>
<?php
if ($query->num_rows() > 0) {
    $row = $query->row();
    ?>
    <div class="box">
        <div class="box-title">
            <div class="caption"><i class="icon-reorder"></i>Form Ubah Harga Serial</div>
        </div>
        <div class="box-body form">
            <?php echo form_open_multipart($form_action, array('class' => 'form-horizontal form-bordered')); ?>
            <?php echo form_hidden('uri_string', uri_string()); ?>
            <?php echo form_hidden('id', $this->uri->segment(4)); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-2">Tipe Serial</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo $row->serial_type_label; ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Harga</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('price', (isset($this->arr_flashdata['input_price'])) ? $this->arr_flashdata['input_price'] : $row->serial_type_price_log_value, 'size="10" class="form-control" style="text-align:right;"'); ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="form-actions fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-offset-2 col-md-10">
                            <button name="update" type="submit" class="btn btn-success"><i class="icon-ok"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
    <?php
} else {
    echo '<div class="error alert alert-danger"><p>Maaf, data tidak tersedia.</p></div>';
}
?>