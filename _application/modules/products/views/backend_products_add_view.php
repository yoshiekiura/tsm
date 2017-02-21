<h2>Tambah Data Produk</h2>
<div class="box">
    <div class="box-title">
        <div class="caption"><i class="icon-reorder"></i>Form Tambah Data Produk </div>
    </div>
    <div class="box-body form">
        <?php echo form_open_multipart($form_action, array('class' => 'form-horizontal form-bordered')); ?>
        <?php echo form_hidden('uri_string', uri_string()); ?>
        <div class="form-body">

            <div class="form-group">
                <label class="control-label col-md-2">Nama Produk</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('name', (isset($this->arr_flashdata['input_name'])) ? $this->arr_flashdata['input_name'] : '', 'size="40" class="form-control"'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">Deskripsi Produk</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_textarea_tinymce('description', (isset($this->arr_flashdata['input_description'])) ? $this->arr_flashdata['input_description'] : '', 'PageGenerator'); ?>
                    </div>
                </div>
            </div>
            
            <div class="form-group hide">
                <label class="control-label col-md-2">Harga Member</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('member_price', (isset($this->arr_flashdata['input_member_price'])) ? $this->arr_flashdata['input_member_price'] : '', 'size="40" class="form-control"'); ?>
                    </div>
                </div>
            </div>
            <div class="form-group hide">
                <label class="control-label col-md-2">Harga Non-Member</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('nonmember_price', (isset($this->arr_flashdata['input_nonmember_price'])) ? $this->arr_flashdata['input_nonmember_price'] : '', 'size="40" class="form-control"'); ?>
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