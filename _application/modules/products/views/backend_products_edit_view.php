<h2>Ubah Data Produk</h2>
<?php
if ($query->num_rows() > 0) {
    $row = $query->row();

    $image = $row->product_image;
    $directory = _dir_products;
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
            <div class="caption"><i class="icon-reorder"></i>Form Ubah Data Produk</div>
        </div>
        <div class="box-body form">
            <?php echo form_open_multipart($form_action, array('class' => 'form-horizontal form-bordered')); ?>
            <?php echo form_hidden('uri_string', uri_string()); ?>
            <?php echo form_hidden('id', $this->uri->segment(4)); ?>
            <?php echo form_hidden('old_image', $row->product_image); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-2">Nama Produk</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('name', (isset($this->arr_flashdata['input_name'])) ? $this->arr_flashdata['input_title'] : $row->product_name, 'size="40" class="form-control"'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Deskripsi Produk</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_textarea('description', (isset($this->arr_flashdata['input_description'])) ? $this->arr_flashdata['input_description'] : $row->product_description, 'cols="40" rows="5" class="form-control"'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Harga Member</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('member_price', (isset($this->arr_flashdata['input_member_price'])) ? $this->arr_flashdata['input_member_price'] : $row->product_price_member, 'size="40" class="form-control"'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">Harga Non-Member</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('nonmember_price', (isset($this->arr_flashdata['input_nonmember_price'])) ? $this->arr_flashdata['input_nonmember_price'] : $row->product_price_non, 'size="40" class="form-control"'); ?>
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