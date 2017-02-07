<h2>Ubah Data Propinsi</h2>
<?php
if ($query->num_rows() > 0) {
    $row = $query->row();
    ?>
    <div class="box">
        <div class="box-title">
            <div class="caption"><i class="icon-reorder"></i>Form Ubah Data Propinsi</div>
        </div>
        <div class="box-body form">
            <?php echo form_open($form_action, array('class' => 'form-horizontal form-bordered')); ?>
            <?php echo form_hidden('uri_string', uri_string()); ?>
            <?php echo form_hidden('id', $this->uri->segment(4)); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-2">Regional</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_dropdown('region_id', $region_options, (isset($this->arr_flashdata['input_region_id'])) ? $this->arr_flashdata['input_region_id'] : $row->province_region_id, 'class="form-control"'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Nama Propinsi</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('name', (isset($this->arr_flashdata['input_name'])) ? $this->arr_flashdata['input_name'] : $row->province_name, 'size="40" class="form-control"'); ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="form-actions fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-offset-2 col-md-10">
                            <button name="insert" type="submit" class="btn btn-success"><i class="icon-ok"></i> Simpan</button>
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