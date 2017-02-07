<?php
$menu_par_id = $this->uri->segment(4, 0);
if($menu_par_id != 0) {
    $title = 'Sub Menu "' . $menu_par_title . '"';
} else {
    $title = 'Menu';
}
?>
<h2>Tambah Data <?php echo $title; ?></h2>
<div class="box">
    <div class="box-title">
        <div class="caption"><i class="icon-reorder"></i>Form Tambah Data <?php echo $title; ?></div>
    </div>
    <div class="box-body form">
        <?php echo form_open($form_action, array('class' => 'form-horizontal form-bordered')); ?>
        <?php echo form_hidden('uri_string', uri_string()); ?>
        <?php echo form_hidden('par_id', $menu_par_id); ?>
        <div class="form-body">

            <div class="form-group">
                <label class="control-label col-md-2">Judul</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('title', (isset($this->arr_flashdata['input_title'])) ? $this->arr_flashdata['input_title'] : '', 'size="60" class="form-control"'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">Link</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('link', (isset($this->arr_flashdata['input_link'])) ? $this->arr_flashdata['input_link'] : '', 'size="60" class="form-control"'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">Class Ikon</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('class', (isset($this->arr_flashdata['input_class'])) ? $this->arr_flashdata['input_class'] : '', 'size="20" class="form-control"'); ?>
                        <!--<br /><small>(referensi: <a href="http://fortawesome.github.io/Font-Awesome/3.2.1/icons/" target="_blank">http://fortawesome.github.io/Font-Awesome/3.2.1/icons/</a>)</small>-->
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