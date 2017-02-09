<h2>Konfigurasi Web</h2>
<?php
if ($query->num_rows() > 0) {
    ?>
    <div class="box">
        <div class="box-title">
            <div class="caption"><i class="icon-reorder"></i>Form Konfigurasi Web</div>
        </div>
        <div class="box-body form">
            <?php echo form_open_multipart($form_action, array('class' => 'form-horizontal form-bordered')); ?>
            <?php echo form_hidden('uri_string', uri_string()); ?>
            <div class="form-body">

                <?php
                foreach ($query->result() as $row) {
                    $input_name = 'input_' . $row->configuration_name;

                    echo '<div class="form-group">';
                    echo '<label class="control-label col-md-2">' . $row->configuration_title . '</label>';
                    echo '<div class="col-md-10">';
                    echo '<div class="input-group" id="defaultrange">';
                    if ($row->configuration_type == 'boolean') {
                        $options = array(1 => 'Ya', 0 => 'Tidak');
                        echo form_dropdown($row->configuration_name, $options, (isset($this->arr_flashdata[$input_name])) ? $this->arr_flashdata[$input_name] : $row->configuration_value, 'class="form-control"');
                    } elseif ($row->configuration_type == 'text') {
                        echo form_input($row->configuration_name, (isset($this->arr_flashdata[$input_name])) ? $this->arr_flashdata[$input_name] : $row->configuration_value, 'size="130" class="form-control"');
                    } elseif ($row->configuration_type == 'textarea') {
                        echo form_textarea($row->configuration_name, (isset($this->arr_flashdata[$input_name])) ? $this->arr_flashdata[$input_name] : $row->configuration_value, 'cols="128" rows="5" class="form-control"');
                    } elseif ($row->configuration_type == 'options') {
                        $options = array();
                        foreach (explode("|", $row->configuration_options) as $option) {
                            $arr_options = explode(":", $option);
                            $options[$arr_options[0]] = $arr_options[1];
                        }
                        echo form_dropdown($row->configuration_name, $options, (isset($this->arr_flashdata[$input_name])) ? $this->arr_flashdata[$input_name] : $row->configuration_value, 'class="form-control"');
                    } elseif ($row->configuration_type == 'file') {
                        $image = $row->configuration_value;
                        $directory = _dir_site_config;
                        if ($image != '' && file_exists($directory . $image)) {
                            $image_source = $image;
                            $image_stat = '<font color="4e9a16"><i>(gambar tersedia)</i></font>';
                            $image_show = '<div><img src="' . base_url() . 'media/' . $directory . '200/200/' . $image_source . '" border="0" alt="' . $image_source . '" /></div>';
                        } else {
                            $image_source = '';
                            $image_stat = '<font color="cd412f"><i>(gambar tidak tersedia)</i></font>';
                            $image_show = '';
                        }
                        echo '<label>' . $image_show . '<br />' . $image_source . '&nbsp;&nbsp;' . $image_stat . '</label><br /><br />';
                        echo form_upload('file_' . $row->configuration_name, '', 'size="50"'); 
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>

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