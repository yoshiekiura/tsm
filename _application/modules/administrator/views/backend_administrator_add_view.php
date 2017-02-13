<h2>Tambah Data Administrator</h2>
<div class="box">
    <div class="box-title">
        <div class="caption"><i class="icon-reorder"></i>Form Tambah Data Administrator</div>
    </div>
    <div class="box-body form">
        <?php echo form_open_multipart($form_action, array('class' => 'form-horizontal form-bordered')); ?>
        <?php echo form_hidden('uri_string', uri_string()); ?>
        <div class="form-body">

            <div class="form-group">
                <label class="control-label col-md-2">Grup</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_dropdown('administrator_group_id', $administrator_group_options, (isset($this->arr_flashdata['input_administrator_group_id'])) ? $this->arr_flashdata['input_administrator_group_id'] : '', 'class="form-control"'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">Username</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('username', (isset($this->arr_flashdata['input_username'])) ? $this->arr_flashdata['input_username'] : '', 'size="30" class="form-control"'); ?>
                        <br /><small>(5 - 15 karakter)</small>
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

            <div class="form-group">
                <label class="control-label col-md-2">Nama</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('name', (isset($this->arr_flashdata['input_name'])) ? $this->arr_flashdata['input_name'] : '', 'size="40" class="form-control"'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">E-Mail</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('email', (isset($this->arr_flashdata['input_email'])) ? $this->arr_flashdata['input_email'] : '', 'size="50" class="form-control"'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">No. Hp</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('mobilephone', (isset($this->arr_flashdata['input_mobilephone'])) ? $this->arr_flashdata['input_mobilephone'] : '', 'size="50" class="form-control"'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">Gambar Profil</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_upload('image', '', 'size="50"'); ?>
                        <?php
                        if(isset($allowed_file_type)) {
                            echo '<br /><small>Format file gambar: <i>' . $allowed_file_type . '</i></small>';
                        }
                        if(isset($image_width) && isset($image_height)) {
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
                        <button name="insert" type="submit" class="btn btn-success"><i class="icon-ok"></i> Simpan</button>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>