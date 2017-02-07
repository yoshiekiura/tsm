<h2>Tambah Data Download File</h2>
<div class="box">
    <div class="box-title">
        <div class="caption"><i class="icon-reorder"></i>Form Tambah Data Download File</div>
    </div>
    <div class="box-body form">
        <?php echo form_open_multipart($form_action, array('class' => 'form-horizontal form-bordered')); ?>
        <?php echo form_hidden('uri_string', uri_string()); ?>
        <div class="form-body">
            
            <div class="form-group">
                <label class="control-label col-md-2">Lokasi</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_dropdown('location', $location_options, (isset($this->arr_flashdata['input_location'])) ? $this->arr_flashdata['input_location'] : '', 'class="form-control"'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">Judul</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('title', (isset($this->arr_flashdata['input_title'])) ? $this->arr_flashdata['input_title'] : '', 'size="40" class="form-control"'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">Deskripsi</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_textarea('description', (isset($this->arr_flashdata['input_description'])) ? $this->arr_flashdata['input_description'] : '', 'cols="40" rows="5" class="form-control"'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">File</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_upload('file', '', 'size="50"'); ?>
                        <?php
                        if(isset($allowed_file_type)) {
                            echo '<br /><small>Format file: <i>' . $allowed_file_type . '</i></small>';
                        }
                        if(isset($max_file)) {
                            echo '<br /><small>(Maksimal: ' . $max_file . ' KB)</small>';
                        }
                        ?>
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