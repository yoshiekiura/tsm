<h2>Ubah Data Menu</h2>
<?php
if ($query->num_rows() > 0) {
    $row = $query->row();
    $menu_type = (isset($this->arr_flashdata['input_type'])) ? $this->arr_flashdata['input_type'] : $row->menu_type;
    switch ($menu_type) {
        case 'page':
            $page_checked = true;
            $modules_checked = false;
            $custom_checked = false;
            $url_checked = false;

            $page_option_disabled = '';
            $modules_option_disabled = 'disabled ';
            $menu_link_readonly = 'readonly ';
            break;

        case 'modules':
            $page_checked = false;
            $modules_checked = true;
            $custom_checked = false;
            $url_checked = false;

            $page_option_disabled = 'disabled ';
            $modules_option_disabled = '';
            $menu_link_readonly = 'readonly ';
            break;

        case 'url':
            $page_checked = false;
            $modules_checked = false;
            $custom_checked = false;
            $url_checked = true;

            $page_option_disabled = 'disabled ';
            $modules_option_disabled = 'disabled ';
            $menu_link_readonly = '';
            break;

        default:
            $page_checked = false;
            $modules_checked = false;
            $custom_checked = true;
            $url_checked = false;

            $page_option_disabled = 'disabled ';
            $modules_option_disabled = 'disabled ';
            $menu_link_readonly = '';
            break;
    }
    ?>
    <div class="box">
        <div class="box-title">
            <div class="caption"><i class="icon-reorder"></i>Form Ubah Data Menu</div>
        </div>
        <div class="box-body form">
            <?php echo form_open($form_action, array('class' => 'form-horizontal form-bordered')); ?>
            <?php echo form_hidden('uri_string', uri_string()); ?>
            <?php echo form_hidden('id', $this->uri->segment(4)); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-2">Judul</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('title', (isset($this->arr_flashdata['input_title'])) ? $this->arr_flashdata['input_title'] : $row->menu_title, 'size="60" class="form-control"'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Tipe Link</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <div class="radio"><label><?php echo form_radio(array('name' => 'type', 'value' => 'page', 'checked' => $page_checked, 'onclick' => 'this.form.modules_link.disabled=true; this.form.page_link.disabled=false; this.form.link.setAttribute(\'readonly\',true); this.form.link.value=this.form.page_link.options[this.form.page_link.selectedIndex].value')); ?>&nbsp;Page Content</label></div><div style="padding-left:28px;"><?php echo form_dropdown('page_link', $page_options, (isset($this->arr_flashdata['input_page_link'])) ? $this->arr_flashdata['input_page_link'] : $row->menu_link, $page_option_disabled . 'onchange=\'this.form.link.value=this.options[this.selectedIndex].value\' class="form-control"'); ?></div><br />
                            <div class="radio"><label><?php echo form_radio(array('name' => 'type', 'value' => 'modules', 'checked' => $modules_checked, 'onclick' => 'this.form.modules_link.disabled=false; this.form.page_link.disabled=true; this.form.link.setAttribute(\'readonly\',true); this.form.link.value=this.form.modules_link.options[this.form.modules_link.selectedIndex].value')); ?>&nbsp;Modules</label></div><div style="padding-left:28px;"><?php echo form_dropdown('modules_link', $modules_options, (isset($this->arr_flashdata['input_modules_link'])) ? $this->arr_flashdata['input_modules_link'] : $row->menu_link, $modules_option_disabled . 'onchange=\'this.form.link.value=this.options[this.selectedIndex].value\' class="form-control"'); ?></div><br />
                            <div class="radio"><label><?php echo form_radio(array('name' => 'type', 'value' => 'custom', 'checked' => $custom_checked, 'onclick' => 'this.form.modules_link.disabled=true; this.form.page_link.disabled=true; this.form.link.removeAttribute(\'readonly\', false); this.form.link.value=\'\'; this.form.link.focus();')); ?>&nbsp;Custom Link</label></div>
                            <div class="radio"><label><?php echo form_radio(array('name' => 'type', 'value' => 'url', 'checked' => $url_checked, 'onclick' => 'this.form.modules_link.disabled=true; this.form.page_link.disabled=true; this.form.link.removeAttribute(\'readonly\', false); this.form.link.value=\'\'; this.form.link.focus();')); ?>&nbsp;Url Link</label></div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Link</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('link', (isset($this->arr_flashdata['input_link'])) ? $this->arr_flashdata['input_link'] : $row->menu_link, $menu_link_readonly . 'size="60" class="form-control"'); ?>
                        </div>
                    </div>
                </div>
                <?php if ($row->menu_par_id == 0): ?>
                <div class="form-group">
                    <label class="control-label col-md-2">Block</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_dropdown('block', $block_options, (isset($this->arr_flashdata['input_block'])) ? $this->arr_flashdata['input_block'] : $row->menu_block, 'class="form-control"'); ?>
                        </div>
                    </div>
                </div>
                <?php endif ?>

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