<h2>Ubah Data Galeri Item</h2>
<?php
if ($query->num_rows() > 0) {
    $row = $query->row();

    $image = $row->product_item_image;
    $directory = _dir_products_item;
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
            <div class="caption"><i class="icon-reorder"></i>Form Ubah Data Produk Item</div>
        </div>
        <div class="box-body form">
            <?php echo form_open_multipart($form_action, array('class' => 'form-horizontal form-bordered')); ?>
            <?php echo form_hidden('uri_string', uri_string()); ?>
            <?php echo form_hidden('id', $this->uri->segment(4)); ?>
            <?php echo form_hidden('old_image', $row->product_item_image); ?>
            <div class="form-body">

            <div class="form-group">
                <label class="control-label col-md-2">Nama Produk</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('subproduct_name', (isset($this->arr_flashdata['input_subproduct_name'])) ? $this->arr_flashdata['input_subproduct_name'] : $row->product_item_name, 'size="40" class="form-control"'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">Komposisi</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_textarea('subproduct_composition', (isset($this->arr_flashdata['input_subproduct_composition'])) ? $this->arr_flashdata['input_subproduct_composition'] : $row->product_item_ingredient, 'cols="40" rows="5" class="form-control"'); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">Manfaat</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_textarea('subproduct_benefit', (isset($this->arr_flashdata['input_subproduct_benefit'])) ? $this->arr_flashdata['input_subproduct_benefit'] : $row->product_item_benefit, 'cols="40" rows="5" class="form-control"'); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">Penggunaan</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_textarea('subproduct_usage', (isset($this->arr_flashdata['input_subproduct_usage'])) ? $this->arr_flashdata['input_subproduct_usage'] : $row->product_item_how_to_use, 'cols="40" rows="5" class="form-control"'); ?>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-2">Harga</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('subproduct_price', (isset($this->arr_flashdata['input_subproduct_price'])) ? $this->arr_flashdata['input_subproduct_price'] : $row->product_item_price, 'size="40" class="form-control"'); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">KODE BPOM</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('subproduct_bpom', (isset($this->arr_flashdata['subproduct_bpom'])) ? $this->arr_flashdata['subproduct_bpom'] : $row->product_item_bpom, 'size="40" class="form-control"'); ?>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-2">File Gambar</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <label><?php echo $image_show; ?><br /><?php echo $image_source; ?>&nbsp;&nbsp;<?php echo $image_stat; ?></label><br /><br />
                        <?php echo form_upload('subproduct_image', '', 'size="50"'); ?>
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