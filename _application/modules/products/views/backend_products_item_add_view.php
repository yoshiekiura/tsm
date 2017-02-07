<h2>Tambah Data Item Produk &raquo; <?php echo $product_name; ?></h2>
<div class="box">
    <div class="box-title">
        <div class="caption"><i class="icon-reorder"></i>Form Tambah Data Item Produk</div>
    </div>
    <div class="box-body form">
        <?php echo form_open_multipart($form_action, array('class' => 'form-horizontal form-bordered')); ?>
        <?php echo form_hidden('uri_string', uri_string()); ?>
        <?php echo form_hidden('product_id', $product_id); ?>
        <div class="form-body">

            <div class="form-group">
                <label class="control-label col-md-2">Nama Produk</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('subproduct_name', (isset($this->arr_flashdata['input_subproduct_name'])) ? $this->arr_flashdata['input_subproduct_name'] : '', 'size="40" class="form-control"'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">Komposisi</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_textarea('subproduct_composition', (isset($this->arr_flashdata['input_subproduct_composition'])) ? $this->arr_flashdata['input_subproduct_composition'] : '', 'cols="40" rows="5" class="form-control"'); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">Manfaat</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_textarea('subproduct_benefit', (isset($this->arr_flashdata['input_subproduct_benefit'])) ? $this->arr_flashdata['input_subproduct_benefit'] : '', 'cols="40" rows="5" class="form-control"'); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">Penggunaan</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_textarea('subproduct_usage', (isset($this->arr_flashdata['input_subproduct_usage'])) ? $this->arr_flashdata['input_subproduct_usage'] : '', 'cols="40" rows="5" class="form-control"'); ?>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-2">Harga</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('subproduct_price', (isset($this->arr_flashdata['input_subproduct_price'])) ? $this->arr_flashdata['input_subproduct_price'] : '', 'size="40" class="form-control"'); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">KODE BPOM</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('subproduct_bpom', (isset($this->arr_flashdata['subproduct_bpom'])) ? $this->arr_flashdata['subproduct_bpom'] : '', 'size="40" class="form-control"'); ?>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-2">File Gambar</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
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
                        <button name="insert" type="submit" class="btn btn-success"><i class="icon-ok"></i> Simpan</button>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>