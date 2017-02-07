<h2>Ubah Data Testimoni</h2>
<?php
if ($query->num_rows() > 0) {
    $row = $query->row();
    ?>
    <div class="box">
        <div class="box-title">
            <div class="caption"><i class="icon-reorder"></i>Form Ubah Data Testimoni</div>
        </div>
        <div class="box-body form">
            <?php echo form_open($form_action, array('class' => 'form-horizontal form-bordered')); ?>
            <?php echo form_hidden('uri_string', uri_string()); ?>
            <?php echo form_hidden('category', $category); ?>
            <?php echo form_hidden('id', $this->uri->segment(5)); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-2">Kategori</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php
                            if($category == 'member') {
                                echo 'Member';
                            } else {
                                echo 'Umum';
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Nama</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php
                            if($category == 'member') {
                                echo $row->member_name;
                            } else {
                                echo form_input('name', (isset($this->arr_flashdata['input_name'])) ? $this->arr_flashdata['input_name'] : $row->testimony_name, 'size="40" class="form-control"');
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Isi Testimoni</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_textarea('content', (isset($this->arr_flashdata['input_content'])) ? $this->arr_flashdata['input_content'] : $row->testimony_content, 'cols="60" rows="10" class="form-control"'); ?>
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