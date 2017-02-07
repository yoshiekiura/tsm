<h2>Konfigurasi Sistem</h2>
<?php
if ($query->num_rows() > 0) {
    ?>
    <div class="box">
        <div class="box-title">
            <div class="caption"><i class="icon-reorder"></i>Form Konfigurasi Sistem</div>
        </div>
        <div class="box-body form">
            <?php echo form_open_multipart($form_action, array('class' => 'form-horizontal form-bordered')); ?>
            <?php echo form_hidden('uri_string', uri_string()); ?>
            <div class="form-body">

                <?php
                foreach ($query->result() as $row) {
                    $input_name = 'input_' . $row->configuration_name;

                    echo '<div class="form-group">';
                    echo '<label class="control-label col-md-3">' . $row->configuration_title . '</label>';
                    echo '<div class="col-md-6">';
                    echo '<div class="input-group" id="defaultrange">';
                    if ($row->configuration_type == 'boolean') {
                        $options = array(0 => 'Ya', 1 => 'Tidak');
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
                        <div class="col-md-offset-3 col-md-9">
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