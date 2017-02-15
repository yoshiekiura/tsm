<?php
if ($query->num_rows() > 0) {
    $row = $query->row();
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Ubah Password</h3>
                </div>
                <?php echo form_open($form_action, array('class' => 'form-horizontal form-bordered')); ?>
                <?php echo form_hidden('uri_string', uri_string()); ?>
                <?php echo form_hidden('id', $this->uri->segment(4)); ?>
                <div class="box-body">
                    
                    <div class="form-group">
                        <label class="control-label col-md-2">Password Lama</label>
                        <div class="col-md-10">
                            <div class="input-group" id="defaultrange">
                                <?php echo form_password('old_password', '', 'size="30" class="form-control"'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">Password Baru</label>
                        <div class="col-md-10">
                            <div class="input-group" id="defaultrange">
                                <?php echo form_password('password', '', 'size="30" class="form-control"'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">Ulangi Password Baru</label>
                        <div class="col-md-10">
                            <div class="input-group" id="defaultrange">
                                <?php echo form_password('password_conf', '', 'size="30" class="form-control"'); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group" style="border-bottom:1px solid #eee;">
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <h4>Konfirmasi PIN</h4>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">PIN Serial</label>
                        <div class="col-md-10">
                            <div class="input-group" id="defaultrange">
                                <?php echo form_input('validate_pin', (isset($this->arr_flashdata['input_validate_pin'])) ? $this->arr_flashdata['input_validate_pin'] : '', 'size="30" class="form-control"'); ?>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="box-footer">
                    <div class="col-md-offset-2 col-md-10">
                        <button name="update" type="submit" class="btn btn-success"><i class="icon-ok"></i> Simpan</button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <?php
} else {
    echo '<div class="error alert alert-danger"><p>Maaf, data tidak tersedia.</p></div>';
}
?>