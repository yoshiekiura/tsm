<h2>Detail Data Member</h2>
<?php
if ($query->num_rows() > 0) {
    $row = $query->row();

    $image = $row->member_detail_image;
    $directory = _dir_member;
    if ($image != '' && file_exists($directory . $image)) {
        $image_source = $image;
        $image_stat = '<font color="4e9a16"><i>(gambar profil tersedia)</i></font>';
        $image_show = '<div><img src="' . base_url() . 'media/' . $directory . '200/75/' . $image_source . '" border="0" alt="' . $image_source . '" /></div>';
    } else {
        $image_source = '';
        $image_stat = '<font color="cd412f"><i>(gambar profil tidak tersedia)</i></font>';
        $image_show = '';
    }
    ?>
    <div class="box">
        <div class="box-title">
            <div class="caption"><i class="icon-reorder"></i>Detail Data Member</div>
        </div>
        <div class="box-body form">
            <div class="form-horizontal form-bordered">
                <div class="form-body">

                    <div class="form-group" style="background-color:#eee;">
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <strong>DATA JARINGAN</strong>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Kode Member</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo ($row->network_code != '') ? $row->network_code : '-'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Sponsor</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo $row->sponsor_network_code; ?> (<?php echo $row->sponsor_member_name; ?>)
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Kode Upline</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo $row->upline_network_code; ?> (<?php echo $row->upline_member_name; ?>)
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Posisi</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo ($row->network_position_text != '') ? $row->network_position_text : '-'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">No. Serial</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo ($row->serial_id != '') ? $row->serial_id : '-'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">PIN</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo ($row->serial_pin != '') ? $row->serial_pin : '-'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="background-color:#eee;">
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <strong>DATA PROFIL</strong>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Username</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo ($row->member_account_username != '') ? $row->member_account_username : '-'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Nama Lengkap</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo ($row->member_name != '') ? $row->member_name : '-'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Nama Alias</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo ($row->member_nickname != '') ? $row->member_nickname : '-'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Alamat</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo ($row->member_detail_address != '') ? nl2br($row->member_detail_address) : '-'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Kota / Kabupaten</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo ($row->member_city_name != '') ? $row->member_city_name : '-'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Propinsi</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo ($row->member_province_name != '') ? $row->member_province_name : '-'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Kode Pos</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo ($row->member_detail_zipcode != '') ? $row->member_detail_zipcode : '-'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Negara</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo ($row->member_country_name != '') ? $row->member_country_name : '-'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Jenis Kelamin</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo ($row->member_detail_sex_text != '') ? $row->member_detail_sex_text : '-'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Tempat / Tanggal Lahir</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo ($row->member_detail_birth_place != '') ? $row->member_detail_birth_place : '-'; ?> / <?php echo ($row->member_detail_birth_date != '') ? convert_date($row->member_detail_birth_date, 'id') : '-'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Identitas / No. Identitas</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo ($row->member_detail_identity_type != '') ? $row->member_detail_identity_type : '-'; ?> / <?php echo ($row->member_detail_identity_no != '') ? $row->member_detail_identity_no : '-'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">No. Telepon</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo ($row->member_phone != '') ? $row->member_phone : '-'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">No. Handphone</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo ($row->member_mobilephone != '') ? $row->member_mobilephone : '-'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">E-mail</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo ($row->member_detail_email != '') ? $row->member_detail_email : '-'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Gambar Profil</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <label><?php echo $image_show; ?><br /><?php echo $image_source; ?>&nbsp;&nbsp;<?php echo $image_stat; ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="background-color:#eee;">
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <strong>DATA BANK</strong>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Bank</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo ($row->member_bank_name != '') ? $row->member_bank_name : '-'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Kota Bank</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo ($row->member_bank_city != '') ? $row->member_bank_city : '-'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Cabang Bank</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo ($row->member_bank_branch != '') ? $row->member_bank_branch : '-'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Nama Rekening</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo ($row->member_bank_account_name != '') ? $row->member_bank_account_name : '-'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">No. Rekening</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo ($row->member_bank_account_no != '') ? $row->member_bank_account_no : '-'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="background-color:#eee;">
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <strong>DATA PEWARIS</strong>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Nama Pewaris</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo ($row->member_devisor_name != '') ? $row->member_devisor_name : '-'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Nama Pewaris</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo ($row->member_devisor_relation != '') ? $row->member_devisor_relation : '-'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">No. Telepon Pewaris</label>
                        <div class="col-md-6">
                            <div class="input-group" id="defaultrange">
                                <?php echo ($row->member_devisor_phone != '') ? $row->member_devisor_phone : '-'; ?>
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