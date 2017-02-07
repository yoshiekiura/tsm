<h2>Detail Buku Tamu</h2>
<?php
if ($query->num_rows() > 0) {
    $row = $query->row();

    
    ?>
    <div class="box">
        <div class="box-title">
            <div class="caption"><i class="icon-reorder"></i>Detail Buku Tamu</div>
        </div>
        <div class="box-body form">
            <div class="form-horizontal form-bordered">
                <div class="form-body">
                    
                    <div class="form-group">
                        <label class="control-label col-md-3">Tanggal</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo convert_datetime($row->guestbook_input_datetime, 'id'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Nama</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo $row->guestbook_name; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Subject</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo $row->guestbook_subject; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Alamat</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo $row->guestbook_address; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Kota</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo $row->guestbook_city; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Negara</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo $row->guestbook_country_name; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">No. Telepon</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo $row->guestbook_phone; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3">No. Handphone</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo $row->guestbook_mobilephone; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3">Email</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo $row->guestbook_email; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3">Pesan</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo nl2br($row->guestbook_message); ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    echo '<div class="error alert alert-danger"><p>Maaf, data tidak tersedia.</p></div>';
}
?>