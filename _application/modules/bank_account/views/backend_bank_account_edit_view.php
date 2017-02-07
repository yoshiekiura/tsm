<h2>Ubah Data Rekening</h2>
<?php
if ($query->num_rows() > 0) {
    $row = $query->row();
    ?>
    <div class="box">
        <div class="box-title">
            <div class="caption"><i class="icon-reorder"></i>Form Ubah Data Rekening</div>
        </div>
        <div class="box-body form">
            <?php echo form_open($form_action, array('class' => 'form-horizontal form-bordered')); ?>
            <?php echo form_hidden('uri_string', uri_string()); ?>
            <?php echo form_hidden('id', $this->uri->segment(4)); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-2">Bank</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_dropdown('bank_id', $bank_options, (isset($this->arr_flashdata['input_bank_id'])) ? $this->arr_flashdata['input_bank_id'] : $row->bank_account_bank_id, 'class="form-control"'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Nama Rekening</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('name', (isset($this->arr_flashdata['input_name'])) ? $this->arr_flashdata['input_name'] : $row->bank_account_name, 'size="40" class="form-control"'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">No. Rekening</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('no', (isset($this->arr_flashdata['input_no'])) ? $this->arr_flashdata['input_no'] : $row->bank_account_no, 'size="40" class="form-control"'); ?>
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