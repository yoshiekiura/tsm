<h2>Ubah Data Download File</h2>
<?php
if ($query->num_rows() > 0) {
    $row = $query->row();

    $file = $row->downloads_file;
    $directory = _dir_downloads;
    if ($file != '' && file_exists($directory . $file)) {
        $file_source = $file;
        $file_stat = '<font color="4e9a16"><i>(file tersedia)</i></font>';
    } else {
        $file_source = '';
        $file_stat = '<font color="cd412f"><i>(file tidak tersedia)</i></font>';
    }
    ?>
    <div class="box">
        <div class="box-title">
            <div class="caption"><i class="icon-reorder"></i>Form Ubah Data Download File</div>
        </div>
        <div class="box-body form">
            <?php echo form_open_multipart($form_action, array('class' => 'form-horizontal form-bordered')); ?>
            <?php echo form_hidden('uri_string', uri_string()); ?>
            <?php echo form_hidden('id', $this->uri->segment(4)); ?>
            <?php echo form_hidden('old_file', $row->downloads_file); ?>
            <div class="form-body">
            
                <div class="form-group">
                    <label class="control-label col-md-2">Lokasi</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_dropdown('location', $location_options, (isset($this->arr_flashdata['input_location'])) ? $this->arr_flashdata['input_location'] : $row->downloads_location, 'class="form-control"'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Judul</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('title', (isset($this->arr_flashdata['input_title'])) ? $this->arr_flashdata['input_title'] : $row->downloads_title, 'size="40" class="form-control"'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Deskripsi</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_textarea('description', (isset($this->arr_flashdata['input_description'])) ? $this->arr_flashdata['input_description'] : $row->downloads_description, 'cols="40" rows="5" class="form-control"'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">File</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <label><?php echo $file_source; ?>&nbsp;&nbsp;<?php echo $file_stat; ?></label><br /><br />
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