<h2>Ubah Data Reward</h2>
<?php
if ($query->num_rows() > 0) {
    $row = $query->row();

    $image = $row->reward_image;
    $directory = _dir_reward;
    if ($image != '' && file_exists($directory . $image)) {
        $image_source = $image;
        $image_stat = '<font color="4e9a16"><i>(gambar tersedia)</i></font>';
        $image_show = '<div><img src="' . base_url() . 'media/' . $directory . '200/200/' . $image_source . '" border="0" alt="' . $image_source . '" /></div>';
    } else {
        $image_source = '';
        $image_stat = '<font color="cd412f"><i>(gambar tidak tersedia)</i></font>';
        $image_show = '';
    }
    ?>
    <div class="box">
        <div class="box-title">
            <div class="caption"><i class="icon-reorder"></i>Form Ubah Data Reward</div>
        </div>
        <div class="box-body form">
            <?php echo form_open_multipart($form_action, array('class' => 'form-horizontal form-bordered')); ?>
            <?php echo form_hidden('uri_string', uri_string()); ?>
            <?php echo form_hidden('id', $this->uri->segment(4)); ?>
            <?php echo form_hidden('old_image', $row->reward_image); ?>
            <div class="form-body">
                <div class="form-group">
                    <label class="control-label col-md-2">Item Reward</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('bonus_reward_item', (isset($this->arr_flashdata['input_bonus_reward_item'])) ? $this->arr_flashdata['input_bonus_reward_item'] : $row->reward_bonus, 'size="40" class="form-control"'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">Nominal Bonus Reward</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('bonus_reward_value', (isset($this->arr_flashdata['input_bonus_reward_value'])) ? $this->arr_flashdata['input_bonus_reward_value'] : $row->reward_bonus_value, 'size="40" class="form-control"'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">Syarat Kaki Kiri</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('condition_left', (isset($this->arr_flashdata['input_condition_left'])) ? $this->arr_flashdata['input_condition_left'] : $row->reward_cond_node_left, 'size="40" class="form-control"'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">Syarat Kaki Kanan</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('condition_right', (isset($this->arr_flashdata['input_condition_right'])) ? $this->arr_flashdata['input_condition_right'] : $row->reward_cond_node_right, 'size="40" class="form-control"'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">Keterangan</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_textarea('bonus_reward_note', (isset($this->arr_flashdata['input_bonus_reward_note'])) ? $this->arr_flashdata['input_bonus_reward_note'] : $row->reward_note, 'style="width:600px; height:150px;resize:none;" class="form-control"'); ?>
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