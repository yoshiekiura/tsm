<h2>Ubah Halaman</h2>
<?php
if ($query->num_rows() > 0) {
    $row = $query->row();

    $update_menu_options[0] = 'Tidak';
    $update_menu_options[1] = 'Ya';
    ?>
    <div class="box">
        <div class="box-title">
            <div class="caption"><i class="icon-reorder"></i>Form Ubah Halaman</div>
        </div>
        <div class="box-body form">
            <?php echo form_open($form_action, array('class' => 'form-horizontal form-bordered')); ?>
            <?php echo form_hidden('uri_string', uri_string()); ?>
            <?php echo form_hidden('id', $this->uri->segment(4)); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-2">Ubah Judul Menu</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_dropdown('is_update_menu', $update_menu_options, (isset($this->arr_flashdata['input_is_update_menu'])) ? $this->arr_flashdata['input_is_update_menu'] : '', 'class="form-control"'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Judul</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('title', (isset($this->arr_flashdata['input_title'])) ? $this->arr_flashdata['input_title'] : $row->page_title, 'size="80" class="form-control"'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Isi</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_textarea_tinymce('page_content', (isset($this->arr_flashdata['input_page_content'])) ? $this->arr_flashdata['input_page_content'] : $row->page_content, 'PageGenerator'); ?>
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