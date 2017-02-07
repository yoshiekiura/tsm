<h2>Konfigurasi Buku Tamu</h2>
<?php
if ($query->num_rows() > 0) {
    ?>
    <div class="box">
        <div class="box-title">
            <div class="caption"><i class="icon-reorder"></i>Form Konfigurasi Buku Tamu</div>
        </div>
        <div class="box-body form">
            <?php echo form_open_multipart($form_action, array('class' => 'form-horizontal form-bordered')); ?>
            <?php echo form_hidden('uri_string', uri_string()); ?>
            <div class="form-body">

                <?php
                foreach ($query->result() as $row) {
                    $input_name = 'input_' . $row->guestbook_configuration_name;

                    echo '<div class="form-group">';
                    echo '<label class="control-label col-md-2">' . $row->guestbook_configuration_title . '</label>';
                    echo '<div class="col-md-10">';
                    echo '<div class="input-group" id="defaultrange">';
                    if ($row->guestbook_configuration_type == 'boolean') {
                        $options = array('true' => 'Ya', 'false' => 'Tidak');
                        echo form_dropdown($row->guestbook_configuration_name, $options, (isset($this->arr_flashdata[$input_name])) ? $this->arr_flashdata[$input_name] : $row->guestbook_configuration_value, 'class="form-control"');
                    } elseif ($row->guestbook_configuration_type == 'text') {
                        echo form_input($row->guestbook_configuration_name, (isset($this->arr_flashdata[$input_name])) ? $this->arr_flashdata[$input_name] : $row->guestbook_configuration_value, 'size="130" class="form-control"');
                    } elseif ($row->guestbook_configuration_type == 'textarea') {
                        echo form_textarea($row->guestbook_configuration_name, (isset($this->arr_flashdata[$input_name])) ? $this->arr_flashdata[$input_name] : $row->guestbook_configuration_value, 'cols="128" rows="5" class="form-control"');
                    } elseif($row->guestbook_configuration_type == 'textarea_editor') {
                        echo form_textarea_tinymce($row->guestbook_configuration_name, (isset($this->arr_flashdata[$input_name])) ? $this->arr_flashdata[$input_name] : $row->guestbook_configuration_value, 'PageGenerator');
                    } elseif($row->guestbook_configuration_type == 'simple_textarea_editor') {
                        echo form_textarea_tinymce($row->guestbook_configuration_name, (isset($this->arr_flashdata[$input_name])) ? $this->arr_flashdata[$input_name] : $row->guestbook_configuration_value, 'Standard');
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