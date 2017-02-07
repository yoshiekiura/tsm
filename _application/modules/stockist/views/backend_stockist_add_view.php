<h2>Tambah Stockist</h2>
<div class="box">
    <div class="box-title">
        <div class="caption"><i class="icon-reorder"></i>Form Tambah Stockist</div>
    </div>
    <div class="box-body form">
        <?php echo form_open_multipart($form_action, array('class' => 'form-horizontal form-bordered')); ?>
        <?php echo form_hidden('uri_string', uri_string()); ?>
        <div class="form-body">

            <div class="form-group">
                <label class="control-label col-md-2">Judul</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('title', (isset($this->arr_flashdata['input_title'])) ? $this->arr_flashdata['input_title'] : '', 'size="80" class="form-control"'); ?>
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