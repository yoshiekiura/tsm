<style>
    .required {
        color:#dd0000;
        font-family:verdana;
        font-size:11pt;
    }
    .text_success {
        font-style:italic;
        color:#008800;
    }
    .text_error {
        font-style:italic;
        color:#dd0000;
    }
</style>
<?php
if (isset($_SESSION['input_message']) && is_serialized($_SESSION['input_message'])) {
    $arr_message = unserialize($_SESSION['input_message']);

    echo $arr_message['message'];
    $_SESSION['input_message'] = array();
}
?>
<?php
if ($query->num_rows() > 0) {
    $row = $query->row();

    $image = $row->member_detail_image;
    $directory = _dir_member;
    if ($image != '' && file_exists($directory . $image)) {
        $image_source = $image;
        $image_stat = '<font color="4e9a16"><i>(gambar profil tersedia)</i></font>';
        $image_show = '<div><img src="' . base_url() . 'media/' . $directory . '100/100/' . $image_source . '" border="0" alt="' . $image_source . '" /></div>';
    } else {
        $image_source = '';
        $image_stat = '<font color="cd412f"><i>(gambar profil tidak tersedia)</i></font>';
        $image_show = '';
    }
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Ubah Data Profil</h3>
                </div>
                <?php echo form_open_multipart($form_action, array('class' => 'form-horizontal form-bordered')); ?>
                <?php echo form_hidden('uri_string', uri_string()); ?>
                <?php echo form_hidden('detail_old_image', $row->member_detail_image); ?>
                <div class="box-body">

                    <div class="form-group" style="border-bottom:1px solid #eee;">
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <h4>DATA JARINGAN</h4>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Kode Member</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php echo $row->network_code; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Sponsor</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php echo $row->sponsor_network_code; ?> (<?php echo $row->sponsor_member_name; ?>)
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Kode Upline</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php echo $row->upline_network_code; ?> (<?php echo $row->upline_member_name; ?>)
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Posisi</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php echo $row->network_position_text; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">No. Serial</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php echo $row->serial_id; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="border-bottom:1px solid #eee;">
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <h4>DATA PROFIL</h4>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Username</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php echo form_input('account_username', (isset($this->arr_flashdata['input_account_username'])) ? $this->arr_flashdata['input_account_username'] : $row->member_account_username, 'size="20" class="form-control"'); ?>
                                <br /><small>(Minimal 5 karakter dan hanya diisi huruf, angka, tanda '-', dan tanda '_')</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Nama Lengkap</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php echo form_input('name', (isset($this->arr_flashdata['input_name'])) ? $this->arr_flashdata['input_name'] : $row->member_name, 'size="40" class="form-control"'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Nama Alias</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php echo form_input('nickname', (isset($this->arr_flashdata['input_nickname'])) ? $this->arr_flashdata['input_nickname'] : $row->member_nickname, 'size="20" class="form-control"'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Alamat</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php echo form_textarea('detail_address', (isset($this->arr_flashdata['input_detail_address'])) ? $this->arr_flashdata['input_detail_address'] : $row->member_detail_address, 'cols="50" rows="3" class="form-control"'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Kota / Kabupaten</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php echo form_dropdown('city_id', $city_options, (isset($this->arr_flashdata['input_city_id'])) ? $this->arr_flashdata['input_city_id'] : $row->member_city_id, 'class="form-control"'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Kode Pos</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php echo form_input('detail_zipcode', (isset($this->arr_flashdata['input_detail_zipcode'])) ? $this->arr_flashdata['input_detail_zipcode'] : $row->member_detail_zipcode, 'size="8" class="form-control"'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Negara</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php echo form_dropdown('country_id', $country_options, (isset($this->arr_flashdata['input_country_id'])) ? $this->arr_flashdata['input_country_id'] : $row->member_country_id, 'class="form-control"'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Jenis Kelamin</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php echo form_dropdown('detail_sex', $sex_options, (isset($this->arr_flashdata['input_detail_sex'])) ? $this->arr_flashdata['input_detail_sex'] : $row->member_detail_sex, 'class="form-control"'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Tempat / Tanggal Lahir</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php echo form_input('detail_birth_place', (isset($this->arr_flashdata['input_detail_birth_place'])) ? $this->arr_flashdata['input_detail_birth_place'] : $row->member_detail_birth_place, 'size="25" class="form-control" style="width:60%; margin-right:1px;"'); ?>
                                <?php echo form_input('detail_birth_date', (isset($this->arr_flashdata['input_detail_birth_date'])) ? $this->arr_flashdata['input_detail_birth_date'] : date_converter($row->member_detail_birth_date, 'd-m-Y'), 'size="10" class="form-control" id="birth_date" style="width:39%;"'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Identitas / No. Identitas</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php
                                if ($row->member_detail_identity_type == '') {
                                    echo form_dropdown('detail_identity_type', $identity_type_options, (isset($this->arr_flashdata['input_detail_identity_type'])) ? $this->arr_flashdata['input_detail_identity_type'] : $row->member_detail_identity_type, 'class="form-control" style="float:left; width:30%;"');
                                } else {
                                    echo $row->member_detail_identity_type;
                                }
                                ?>

                                <?php
                                if ($row->member_detail_identity_no == '') {
                                    echo form_input('detail_identity_no', (isset($this->arr_flashdata['input_detail_identity_no'])) ? $this->arr_flashdata['input_detail_identity_no'] : $row->member_detail_identity_no, 'size="25" class="form-control" style="float:right; width:69%;"');
                                } else {
                                    echo $row->member_detail_identity_no;
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">No. Telepon</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php echo form_input('phone', (isset($this->arr_flashdata['input_phone'])) ? $this->arr_flashdata['input_phone'] : $row->member_phone, 'size="20" class="form-control"'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">No. Handphone</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php
                                //echo 
                                //form_input('mobilephone', (isset($this->arr_flashdata['input_mobilephone'])) ? $this->arr_flashdata['input_mobilephone'] : $row->member_mobilephone, 'size="20" class="form-control"'); 
                                if ($row->member_mobilephone == '') {

                                    echo form_input('mobilephone', (isset($this->arr_flashdata['input_mobilephone'])) ? $this->arr_flashdata['input_mobilephone'] : $row->member_mobilephone, 'size="20" class="form-control"');
                                } else {
                                    echo $row->member_mobilephone;
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">E-mail</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php echo form_input('detail_email', (isset($this->arr_flashdata['input_detail_email'])) ? $this->arr_flashdata['input_detail_email'] : $row->member_detail_email, 'size="40" class="form-control"'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Gambar Profil</label>
                        <div class="col-md-9">
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

                    <div class="form-group" style="border-bottom:1px solid #eee;">
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <h4>DATA BANK</h4>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Bank</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php echo form_dropdown('bank_bank_id', $bank_options, (isset($this->arr_flashdata['input_bank_bank_id'])) ? $this->arr_flashdata['input_bank_bank_id'] : $row->member_bank_bank_id, 'class="form-control"' . ((!empty($row->member_bank_bank_id) OR $row->member_bank_bank_id) != 0 ? '  disabled="disabled"' : '')); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Kota Bank</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php echo form_input('bank_city', (isset($this->arr_flashdata['input_bank_city'])) ? $this->arr_flashdata['input_bank_city'] : $row->member_bank_city, 'size="30" class="form-control"' . (!empty($row->member_bank_city) ? ' disabled="disabled"' : '')); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Cabang Bank</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php echo form_input('bank_branch', (isset($this->arr_flashdata['input_bank_branch'])) ? $this->arr_flashdata['input_bank_branch'] : $row->member_bank_branch, 'size="30" class="form-control"' . (!empty($row->member_bank_branch) ? ' disabled="disabled"' : '')); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Nama Rekening</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php echo form_input('bank_account_name', (isset($this->arr_flashdata['input_bank_account_name'])) ? $this->arr_flashdata['input_bank_account_name'] : $row->member_bank_account_name, 'size="30" class="form-control"' . (!empty($row->member_bank_account_name) ? ' disabled="disabled"' : '')); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">No. Rekening</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php
                                //echo form_input('bank_account_no', (isset($this->arr_flashdata['input_bank_account_no'])) ? $this->arr_flashdata['input_bank_account_no'] : $row->member_bank_account_no, 'size="30" class="form-control"'); 

                                if ($row->member_bank_account_no == '') {
                                    echo form_input('bank_account_no', (isset($this->arr_flashdata['input_bank_account_no'])) ? $this->arr_flashdata['input_bank_account_no'] : $row->member_bank_account_no, 'size="30" class="form-control"');
                                } else {
                                    echo $row->member_bank_account_no;
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="border-bottom:1px solid #eee;">
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <h4>DATA PEWARIS</h4>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Nama Pewaris</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php echo form_input('devisor_name', (isset($this->arr_flashdata['input_devisor_name'])) ? $this->arr_flashdata['input_devisor_name'] : $row->member_devisor_name, 'size="30" class="form-control"'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Nama Pewaris</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php echo form_input('devisor_relation', (isset($this->arr_flashdata['input_devisor_relation'])) ? $this->arr_flashdata['input_devisor_relation'] : $row->member_devisor_relation, 'size="30" class="form-control"'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">No. Telepon Pewaris</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php echo form_input('devisor_phone', (isset($this->arr_flashdata['input_devisor_phone'])) ? $this->arr_flashdata['input_devisor_phone'] : $row->member_devisor_phone, 'size="30" class="form-control"'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="border-bottom:1px solid #eee;">
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <h4>Konfirmasi PIN</h4>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">PIN Serial</label>
                        <div class="col-md-9">
                            <div class="input-group" id="defaultrange">
                                <?php echo form_input('validate_pin', (isset($this->arr_flashdata['input_validate_pin'])) ? $this->arr_flashdata['input_validate_pin'] : '', 'size="30" class="form-control"'); ?>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="box-footer">
                    <div class="col-md-offset-2 col-md-10">
                        <button name="update" type="submit" class="btn btn-success"><i class="icon-ok"></i> Simpan</button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#birth_date").datepicker({
                defaultDate: "+0d",
                changeMonth: true,
                changeYear: true,
                yearRange: "-90:+0",
                dateFormat: 'yyyy-mm-dd',
                format: 'dd-mm-yyyy',
                maxDate: "+0d"
            });
        });
    </script>
    <?php
} else {
    echo '<div class="error alert alert-danger"><p>Maaf, data tidak tersedia.</p></div>';
}
?>