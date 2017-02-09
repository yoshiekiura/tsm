<h2>Ubah Event</h2>
<?php
if ($query->num_rows() > 0) {
    $row = $query->row();

    $image = $row->event_image;
    $directory = _dir_event;
    if ($image != '' && file_exists($directory . $image)) {
        $image_source = $image;
        $image_stat = '<font color="4e9a16"><i>(gambar tersedia)</i></font>';
        $image_show = '<div><img src="' . base_url() . 'media/' . $directory . '150/150/' . $image_source . '" border="0" alt="' . $image_source . '" /></div>';
    } else {
        $image_source = '';
        $image_stat = '<font color="cd412f"><i>(gambar tidak tersedia)</i></font>';
        $image_show = '';
    }
    ?>
    <div class="box">
        <div class="box-title">
            <div class="caption"><i class="icon-reorder"></i>Form Ubah Event</div>
        </div>
        <div class="box-body form">
            <?php echo form_open_multipart($form_action, array('class' => 'form-horizontal form-bordered')); ?>
            <?php echo form_hidden('uri_string', uri_string()); ?>
            <?php echo form_hidden('id', $this->uri->segment(4)); ?>
            <?php echo form_hidden('old_image', $row->event_image); ?>
            <div class="form-body">
                <div class="form-group hide">
                    <label class="control-label col-md-2">Tipe Tempat</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php
                            $options = array('Kantor Pusat' => 'Kantor Pusat', 'Kantor Cabang' => 'Kantor Cabang');
                            echo form_dropdown('event_type', $options, (isset($this->arr_flashdata['input_event_type'])) ? $this->arr_flashdata['input_event_type'] : $row->event_type, 'class="form-control"');
                            ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">Judul</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('title', (isset($this->arr_flashdata['input_title'])) ? $this->arr_flashdata['input_title'] : $row->event_title, 'size="80" class="form-control"'); ?>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                <label class="control-label col-md-2">Tempat</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('event_place', (isset($this->arr_flashdata['input_event_place'])) ? $this->arr_flashdata['input_event_place'] : $row->event_place, 'size="80" class="form-control"'); ?>
                    </div>
                </div>
            </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Kota </label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('event_city', (isset($this->arr_flashdata['event_city'])) ? $this->arr_flashdata['event_city'] : $row->event_city, 'size="20" class="form-control"'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Isi</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_textarea_tinymce('event_description', (isset($this->arr_flashdata['input_event_description'])) ? $this->arr_flashdata['input_event_description'] : $row->event_description, 'PageGenerator'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Keterangan</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('event_note', (isset($this->arr_flashdata['input_event_note'])) ? $this->arr_flashdata['input_event_note'] : $row->event_note, 'size="20" class="form-control"'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Tanggal Event</label>
                    <div class="col-md-10">
                        <?php echo form_input('event_date', (isset($this->arr_flashdata['input_event_date'])) ? $this->arr_flashdata['input_event_date'] : $row->event_date, 'size="10" class="form-control" id="input_event_date" style="width:29%;"'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Jam</label>
                    <div class="col-md-10">
                        <?php echo form_input('event_time', (isset($this->arr_flashdata['input_event_time'])) ? $this->arr_flashdata['input_event_time'] : $row->event_time, 'size="10" class="form-control" id="input_event_time" style="width:29%;"'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">HTM</label>
                    <div class="col-md-10">
                        <?php echo form_input('event_ticket', (isset($this->arr_flashdata['input_event_ticket'])) ? $this->arr_flashdata['input_event_ticket'] : $row->event_ticket, 'size="10" class="form-control" id="input_event_ticket" style="width:29%;"'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">File Gambar</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <label><?php echo $image_show; ?><br /><?php echo $image_source; ?>&nbsp;&nbsp;<?php echo $image_stat; ?></label><br /><br />
                            <?php echo form_upload('image', '', 'size="50"'); ?>
                            <?php
                            if (isset($allowed_file_type)) {
                                echo '<br /><small>Format file gambar: <i>' . $allowed_file_type . '</i></small>';
                            }
                            if (isset($image_width) && isset($image_height)) {
                                echo '<br /><small>(Ukuran terbaik ' . $image_width . 'px x ' . $image_height . 'px)</small>';
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
<script>
    $(document).ready(function() {
        $("#input_event_date").datepicker({
            defaultDate: "+0d",
            changeMonth: true,
            changeYear: true,
            yearRange: "-90:+20",
            dateFormat: 'yy-mm-dd',
            //maxDate: "+0d"
        });
    });
</script>