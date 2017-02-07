<h2>Tambah Data Reward</h2>
<div class="box">
    <div class="box-title">
        <div class="caption"><i class="icon-reorder"></i>Form Tambah Data Reward</div>
    </div>
    <div class="box-body form">
        <?php echo form_open_multipart($form_action, array('class' => 'form-horizontal form-bordered')); ?>
        <?php echo form_hidden('uri_string', uri_string()); ?>
        <div class="form-body">
            <div class="form-group">
                <label class="control-label col-md-2">Item Reward</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('bonus_reward_item', (isset($this->arr_flashdata['input_bonus_reward_item'])) ? $this->arr_flashdata['input_bonus_reward_item'] : '', 'size="40" class="form-control"'); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">Nominal Bonus Reward</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('bonus_reward_value', (isset($this->arr_flashdata['input_bonus_reward_value'])) ? $this->arr_flashdata['input_bonus_reward_value'] : 0, 'size="40" class="form-control"'); ?>
                    </div>
                </div>
            </div> 
            <div class="form-group">
                <label class="control-label col-md-2">Syarat Kaki Kiri</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('condition_left', (isset($this->arr_flashdata['input_condition_left'])) ? $this->arr_flashdata['input_condition_left'] : '', 'size="40" class="form-control"'); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">Syarat Kaki Kanan</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('condition_right', (isset($this->arr_flashdata['input_condition_right'])) ? $this->arr_flashdata['input_condition_right'] : '', 'size="40" class="form-control"'); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">Keterangan</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_textarea('bonus_reward_note', (isset($this->arr_flashdata['input_bonus_reward_note'])) ? $this->arr_flashdata['input_bonus_reward_note'] : '', 'style="width:600px; height:150px;resize:none;" class="form-control"'); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">File Gambar</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_upload('image', '', 'size="50"'); ?>
                        <?php
                        if(isset($allowed_file_type)) {
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
                        <button name="insert" type="submit" class="btn btn-success"><i class="icon-ok"></i> Simpan</button>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>