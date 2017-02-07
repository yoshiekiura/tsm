<?php
if ($query->num_rows() > 0) {
    $row = $query->row();
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Ubah Testimoni</h3>
                </div>

                
                    <?php echo form_open($form_action, array('class' => 'form-horizontal form-bordered')); ?>
                    <?php echo form_hidden('uri_string', uri_string()); ?>
                    <?php echo form_hidden('id', $this->uri->segment(4)); ?>
                    <div class="box-body"

                        <div class="form-group">
                            <label class="control-label col-md-2">Isi Testimoni</label>
                            <div class="col-md-10">
                                <div class="input-group" id="defaultrange">
                                    <?php echo form_textarea('content', (isset($this->arr_flashdata['input_content'])) ? $this->arr_flashdata['input_content'] : $row->testimony_content, 'cols="60" rows="10" class="form-control"'); ?>
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
    </div>
    <?php
} else {
    echo '<div class="error alert alert-danger"><p>Maaf, data tidak tersedia.</p></div>';
}
?>