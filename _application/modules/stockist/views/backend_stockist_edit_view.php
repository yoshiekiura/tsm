<h2>Ubah Stockist</h2>
<?php
if ($query->num_rows() > 0) {
    $row = $query->row();

    $image = $row->stockist_image;
    $directory = _dir_stockist;
    if ($image != '' && file_exists($directory . $image)) {
        $image_source = $image;
        $image_stat = '<font color="4e9a16"><i>(gambar tersedia)</i></font>';
        $image_show = '<div><img src="' . base_url() . 'media/' . $directory . '150/150/' . $image_source . '" border="0" alt="' . $image_source . '" /></div>';
    } else {
        $image_source = '';
        $image_stat = '<font color="cd412f"><i>(gambar tidak tersedia)</i></font>';
        $image_show = '';
    }
    ?>
    <div class="box">
        <div class="box-title">
            <div class="caption"><i class="icon-reorder"></i>Form Ubah Stockist</div>
        </div>
        <div class="box-body form">
            <?php echo form_open_multipart($form_action, array('class' => 'form-horizontal form-bordered')); ?>
            <?php echo form_hidden('uri_string', uri_string()); ?>
            <?php echo form_hidden('id', $this->uri->segment(4)); ?>
            <?php echo form_hidden('old_image', $row->stockist_image); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-2">Judul</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('title', (isset($this->arr_flashdata['input_title'])) ? $this->arr_flashdata['input_title'] : $row->stockist_title, 'size="80" class="form-control"'); ?>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-2">Tempat Stockist</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('place', (isset($this->arr_flashdata['input_place'])) ? $this->arr_flashdata['input_place'] : '', 'size="80" class="form-control"'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Telp. Stockist</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('phone', (isset($this->arr_flashdata['input_stockist_phone'])) ? $this->arr_flashdata['input_stockist_phone'] : '', 'size="80" class="form-control"'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Jam Kerja Stockist</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('time', (isset($this->arr_flashdata['input_stockist_time'])) ? $this->arr_flashdata['input_stockist_time'] : '', 'size="80" class="form-control"'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">File Gambar</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <label><?php echo $image_show; ?><br /><?php echo $image_source; ?>&nbsp;&nbsp;<?php echo $image_stat; ?></label><br /><br />
                            <?php echo form_upload('image', '', 'size="50"'); ?>
                            <?php
                            if (isset($allowed_file_type)) {
                                echo '<br /><small>Format file gambar: <i>' . $allowed_file_type . '</i></small>';
                            }
                            if (isset($image_width) && isset($image_height)) {
                                echo '<br /><small>(Ukuran terbaik ' . $image_width . 'px x ' . $image_height . 'px)</small>';
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