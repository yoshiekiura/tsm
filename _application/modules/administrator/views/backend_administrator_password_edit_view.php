<h2>Ubah Password Administrator</h2>
<?php
if ($query->num_rows() > 0) {
    $row = $query->row();
    ?>
    <div class="box">
        <div class="box-title">
            <div class="caption"><i class="icon-reorder"></i>Form Ubah Administrator</div>
        </div>
        <div class="box-body form">
            <?php echo form_open($form_action, array('class' => 'form-horizontal form-bordered')); ?>
            <?php echo form_hidden('uri_string', uri_string()); ?>
            <?php echo form_hidden('id', $row->administrator_id); ?>
            <div class="form-body">

                <div class="form-group">
                    <label class="control-label col-md-2">Username</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo $row->administrator_username; ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Nama</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo $row->administrator_name; ?>
                        </div>
                    </div>
                </div>

                <!--
                <div class="form-group">
                    <label class="control-label col-md-2">Password Lama</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php //echo form_password('old_password', '', 'size="30" class="form-control"'); ?>
                        </div>
                    </div>
                </div>
                -->

                <div class="form-group">
                    <label class="control-label col-md-2">Password Baru</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_password('password', '', 'size="30" class="form-control"'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Ulangi Password Baru</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_password('password_conf', '', 'size="30" class="form-control"'); ?>
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