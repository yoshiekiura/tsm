<h2>Ubah Halaman Depan <?php echo $title; ?></h2>
<?php
if ($query->num_rows() > 0) {
    $row = $query->row();
    ?>
    <div class="box">
        <div class="box-title">
            <div class="caption"><i class="icon-reorder"></i>Form Ubah Halaman Depan <?php echo $title; ?></div>
        </div>
        <div class="box-body form">
            <?php echo form_open($form_action, array('class' => 'form-horizontal form-bordered')); ?>
            <?php echo form_hidden('uri_string', uri_string()); ?>
            <?php echo form_hidden('location', (isset($this->arr_flashdata['input_location'])) ? $this->arr_flashdata['input_location'] : $row->page_home_location); ?>
            <?php echo form_hidden('id', $row->page_home_id); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-2">Judul</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('title', (isset($this->arr_flashdata['input_title'])) ? $this->arr_flashdata['input_title'] : $row->page_home_title, 'size="80" class="form-control"'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Isi</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_textarea_tinymce('home_content', (isset($this->arr_flashdata['input_home_content'])) ? $this->arr_flashdata['input_home_content'] : $row->page_home_content, 'PageGenerator'); ?>
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