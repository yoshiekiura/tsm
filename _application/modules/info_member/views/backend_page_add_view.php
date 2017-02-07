<h2>Tambah Halaman</h2>
<div class="box">
    <div class="box-title">
        <div class="caption"><i class="icon-reorder"></i>Form Tambah Halaman</div>
    </div>
    <div class="box-body form">
        <?php echo form_open($form_action, array('class' => 'form-horizontal form-bordered')); ?>
        <?php echo form_hidden('uri_string', uri_string()); ?>
        <?php echo form_hidden('par_id', '0'); ?>
        <div class="form-body">

            <div class="form-group">
                <label class="control-label col-md-2">Buat Menu</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_dropdown('is_create_menu', $create_menu_options, (isset($this->arr_flashdata['input_is_create_menu'])) ? $this->arr_flashdata['input_is_create_menu'] : '', 'onchange=\'if(this.form.is_create_menu.options[this.form.is_create_menu.selectedIndex].value=="1") { this.form.par_id.disabled=false; } else { this.form.par_id.disabled=true; } \' class="form-control"'); ?>
                    </div>
                </div>
            </div>

            <!--
            <div class="form-group">
                <label class="control-label col-md-2">Menu Parent</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php //echo form_dropdown('par_id', $menu_parent_options, (isset($this->arr_flashdata['input_par_id'])) ? $this->arr_flashdata['input_par_id'] : '', 'class="form-control"'); ?>
                    </div>
                </div>
            </div>
            -->

            <div class="form-group">
                <label class="control-label col-md-2">Judul</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('title', (isset($this->arr_flashdata['input_title'])) ? $this->arr_flashdata['input_title'] : '', 'size="80" class="form-control"'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">Isi</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_textarea_tinymce('page_content', (isset($this->arr_flashdata['input_page_content'])) ? $this->arr_flashdata['input_page_content'] : '', 'PageGenerator'); ?>
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