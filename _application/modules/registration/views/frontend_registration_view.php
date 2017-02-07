<!-- widget Register -->
<div class="panel panel-default panel-gtl" id="widget-register">
    <div class="panel-heading">
        <h4 style="padding-bottom: 0px;"><small>PENDAFTARAN</small>MEMBER BARU</h4>
    </div>
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
    <div class="panel-body">
        <div class="row">
            <div class="col-md-8">
                <?php //echo (isset($this->arr_flashdata['message'])) ? unserialize($this->arr_flashdata['message']) : ''; 
                if(isset($_SESSION['registration_message']) && is_serialized($_SESSION['registration_message'])) {
                    $arr_message =  unserialize($_SESSION['registration_message']);
                    echo $arr_message;
                    unset($_SESSION['registration_message']);
                }
                
                echo (isset($this->arr_flashdata['message'])) ? $this->arr_flashdata['message'] : '';
                ?>
                <form role="form" class="reg-form" method="post" action="<?php echo $form_action; ?>">
                    <input type="hidden" name="uri_string" value="<?php echo uri_string(); ?>" />
                    <h5 class="divider"><strong>Data Jaringan</strong></h5>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">ID Sponsor <span class="required">*</span></label>
                        <div class="col-sm-7">
                            <input placeholder="ID Sponsor..." type="text" name="reg_sponsor" id="reg_sponsor" value="<?php echo (isset($this->arr_flashdata['input_reg_sponsor'])) ? $this->arr_flashdata['input_reg_sponsor'] : ''; ?>" class="form-control input-sm" rel="popover" data-content="ID Sponsor" data-original-title="ID Sponsor" ><br /><span id="reg_nama_sponsor"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">ID Upline <span class="required">*</span></label>
                        <div class="col-sm-7">
                            <input placeholder="ID Upline..." type="text" name="reg_upline" id="reg_upline" value="<?php echo (isset($this->arr_flashdata['input_reg_upline'])) ? $this->arr_flashdata['input_reg_upline'] : ''; ?>" class="form-control input-sm" rel="popover" data-content="ID Upline" data-original-title="ID Upline" ><br /><span id="reg_nama_upline"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Posisi <span class="required">*</span></label>
                        <div class="col-sm-7">
                            <label class="radio-inline">
                                <input type="radio" name="reg_posisi" id="reg_posisi_kiri" value="kiri" <?php echo (isset($this->arr_flashdata['input_reg_posisi'])) ? (($this->arr_flashdata['input_reg_posisi'] == 'kiri') ? 'checked' : '') : 'checked'; ?>>
                                <span>Kiri&nbsp;&nbsp;</span>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="reg_posisi" id="reg_posisi_kanan" value="kanan" <?php echo (isset($this->arr_flashdata['input_reg_posisi'])) ? (($this->arr_flashdata['input_reg_posisi'] == 'kanan') ? 'checked' : '') : ''; ?>>
                                <span>Kanan</span>
                            </label>
                        </div>
                    </div>                    
                    <br>

                    <h5 class="divider"><strong>Data Kartu</strong></h5>
                    <div class="form-group">
                        <label class="control-label col-sm-4">Paket Join <span class="required">*</span></label>
                        <div class="col-sm-7">
                            <div class="input-group" id="defaultrange">
                                <label style="display:inline-block; float:left; margin-right:15px;">
                                    <input type="radio" name="reg_paket" id="btnpaket1" value="1" style="margin-top:-3px;" <?php echo (isset($this->arr_flashdata['input_reg_paket'])) ? (($this->arr_flashdata['input_reg_paket'] == 1) ? "checked" : '' ) : 'checked'; ?>>
                                    <span>1 HU&nbsp;&nbsp;</span>
                                </label>
                                <label style="display:inline-block; float:left; margin-right:15px;">
                                    <input type="radio" name="reg_paket" id="btnpaket3" value="3" style="margin-top:-3px;" <?php echo (isset($this->arr_flashdata['input_reg_paket'])) ? (($this->arr_flashdata['input_reg_paket'] == 3) ? "checked" : '' ) : ''; ?>>
                                    <span>3 HU</span>
                                </label>
                                <label style="display:inline-block; float:left; margin-right:15px;">
                                    <input type="radio" name="reg_paket" id="btnpaket7" value="7" style="margin-top:-3px;" <?php echo (isset($this->arr_flashdata['input_reg_paket'])) ? (($this->arr_flashdata['input_reg_paket'] == 7) ? "checked" : '' ) : ''; ?>>
                                    <span>7 HU</span>
                                </label>
                                <label style="display:inline-block; float:left; margin-right:15px;">
                                    <input type="radio" name="reg_paket" id="btnpaket15" value="15" style="margin-top:-3px;" <?php echo (isset($this->arr_flashdata['input_reg_paket'])) ? (($this->arr_flashdata['input_reg_paket'] == 15) ? "checked" : '' ) : ''; ?>>
                                    <span>15 HU</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4">Serial - PIN <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <p style="color: #eea236;">Masukkan nomor serial beserta pin aktivasi</p>
                            <div class='row-serial' id='row-serial'>
                                <div class="items">
                                    <div class="col-sm-4" style = "padding-left:0px;">
                                        <label >Nomor Serial 1 <span class="required">*</span></label>
                                        <input type="text" class="form-control" id="serial1" name ="reg_serial[1]" placeholder="nomor serial ..." value="<?php echo (isset($this->arr_flashdata['input_reg_serial'][1])) ? $this->arr_flashdata['input_reg_serial'][1] : ''; ?>">
                                    </div>

                                    <div class="col-sm-4" style = "padding-left:0px;">
                                        <label >PIN 1 <span class="required">*</span></label>
                                        <input type="text" class="form-control" id="pin1" name ="reg_pin[1]" placeholder="pin ..." value="<?php echo (isset($this->arr_flashdata['input_reg_pin'][1])) ? $this->arr_flashdata['input_reg_pin'][1] : ''; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>

                    <h5 class="divider"><strong>Data Pribadi</strong></h5>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nama Lengkap <span class="required">*</span></label>
                        <div class="col-sm-7">
                            <input placeholder="Nama Lengkap..." type="text" name="reg_nama" id="reg_nama" value="<?php echo (isset($this->arr_flashdata['input_reg_nama'])) ? $this->arr_flashdata['input_reg_nama'] : ''; ?>" class="form-control input-sm" ><small>sesuaikan dengan rekening anda</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">Password <span class="required">*</span></label>
                        <div class="col-sm-7">
                            <div class="input-group" id="defaultrange">
                                <input placeholder="Password..." type="password" name="reg_password" id="reg_password" value="<?php echo (isset($this->arr_flashdata['input_reg_password'])) ? $this->arr_flashdata['input_reg_password'] : ''; ?>"  class="form-control input-sm" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4">Konfirmasi Password <span class="required">*</span></label>
                        <div class="col-sm-7">
                            <div class="input-group" id="defaultrange">
                                <input placeholder="masukkan kembali password..." type="password" name="reg_repassword" id="reg_repassword" value="<?php echo (isset($this->arr_flashdata['input_reg_repassword'])) ? $this->arr_flashdata['input_reg_repassword'] : ''; ?>"  class="form-control input-sm" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Email</label>
                        <div class="col-sm-7">
                            <input placeholder="Email..." type="text" name="reg_email" id="reg_email" value="<?php echo (isset($this->arr_flashdata['input_reg_email'])) ? $this->arr_flashdata['input_reg_email'] : ''; ?>" maxlength="50" class="form-control input-sm">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">No. Handphone <span class="required">*</span></label>
                        <div class="col-sm-7">
                            <input placeholder="No. Handphone..." type="text" name="reg_handphone" id="reg_handphone" value="<?php echo (isset($this->arr_flashdata['input_reg_handphone'])) ? $this->arr_flashdata['input_reg_handphone'] : ''; ?>" maxlength="12" class="form-control input-sm" >
                        </div>
                    </div>
                    <br>

                    <h5 class="divider"><strong>Data Bank</strong><br><small>Kosongkan jika Anda belum mempunyai Rekening Bank</small></h5>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-4">Nama Bank</label>
                        <div class="col-sm-7">
                            <!--<div class="input-group" id="defaultrange">-->
                                <select name="reg_id_bank" class="form-control input-sm">
                                    <option value="0" <?php echo (!isset($this->arr_flashdata['input_reg_id_bank'])) ? 'selected="selected"' : ''; ?>>N/A</option>
                                    <?php
                                    if ($query_bank->num_rows() > 0) {
                                        foreach ($query_bank->result() as $row_bank) {
                                            $selected = (isset($this->arr_flashdata['input_reg_id_bank'])) ? (($this->arr_flashdata['input_reg_id_bank'] == $row_bank->bank_id) ? 'selected="selected"' : '') : '';
//                                            $selected ='';
                                            echo '<option value="' . $row_bank->bank_id . '" ' . $selected . '>' . $row_bank->bank_name . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            <!--</div>-->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Cabang</label>
                        <div class="col-sm-7">
                            <input placeholder="Cabang Bank..." type="text" name="reg_cabang_bank" id="reg_cabang_bank"  value="<?php echo (isset($this->arr_flashdata['input_reg_cabank_bank'])) ? $this->arr_flashdata['input_reg_cabank_bank'] : ''; ?>" maxlength="20" class="form-control input-sm">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Kota Bank</label>
                        <div class="col-sm-7">
                            <input placeholder="Kota Bank..." type="text" name="reg_kota_bank" id="reg_kota_bank" value="<?php echo (isset($this->arr_flashdata['input_reg_bank_city'])) ? $this->arr_flashdata['input_reg_bank_city'] : ''; ?>" maxlength="20" class="form-control input-sm">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nama Nasabah</label>
                        <div class="col-sm-7">
                            <input placeholder="Nama Nasabah..." type="text" name="reg_nasabah_bank" id="reg_nasabah_bank" value="<?php echo (isset($this->arr_flashdata['input_reg_nasabah_bank'])) ? $this->arr_flashdata['input_reg_nasabah_bank'] : ''; ?>" class="form-control input-sm">
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="col-sm-4 control-label">No. Rekening</label>
                        <div class="col-sm-7">
                            <input placeholder="Nomor Rekening..." type="text" name="reg_no_rekening_bank" id="reg_no_rekening_bank" value="<?php echo (isset($this->arr_flashdata['input_reg_no_rekening_bank'])) ? $this->arr_flashdata['input_reg_no_rekening_bank'] : ''; ?>" maxlength="20" class="form-control input-sm">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">&nbsp;</label>
                        <div class="col-sm-7">
                            <button name="register" type="submit" value="true" onclick="return confirmation();" class="btn btn-warning btn-block"><i class="fa fa-check-square-o"></i>&nbsp; Aktifkan Akun Saya</button>
                        </div>
                    </div>
                </form>

                <script>
                    $(document).ready(function() {
                        check_member_data('reg_nama_sponsor', $("#reg_sponsor").val());
                        check_member_data('reg_nama_upline', $("#reg_upline").val());

                        $("#reg_sponsor").blur(function() {
                            check_member_data('reg_nama_sponsor', $("#reg_sponsor").val());
                        });

                        $("#reg_upline").blur(function() {
                            check_member_data('reg_nama_upline', $("#reg_upline").val());
                        });

                        $("#reg_nama").blur(function() {
                            $("#reg_nasabah_bank").val($(this).val());
                        });
                    });

                    function check_member_data(id, code) {
                        if (code.length > 0) {
                            $.ajax({
                                type: 'POST',
                                url: 'registration/get_member_name',
                                data: 'code=' + code,
                                dataType: 'json',
                                async: false,
                                success: function(member_name) {
                                    if (member_name.length > 0) {
                                        var result_add_class = 'text_success';
                                        var result_remove_class = 'text_error';
                                        var result_text = member_name;
                                    } else {
                                        var result_add_class = 'text_error';
                                        var result_remove_class = 'text_success';
                                        var result_text = 'Tidak Ditemukan';
                                    }
                                    $("#" + id).html(result_text).removeClass(result_remove_class).addClass(result_add_class);
                                }
                            });
                        }
                    }

                    function confirmation() {
//                        
//                        alert("OK");
                        var sponsor = $("#reg_sponsor").val().toUpperCase();
                        var upline = $("#reg_upline").val().toUpperCase();
                        var nama_anda = $("#reg_nama").val().toUpperCase();
                        var jumlah_hu = $('input[name=reg_paket]:checked').val()
                        var posisi = $('input[name=reg_posisi]:checked').val()
                        var nama_sponsor = $("#reg_nama_sponsor").html();
                        var nama_upline = $("#reg_nama_upline").html();
//
                        if (sponsor.length > 0 && upline.length > 0) {
                            var is_confirmation = confirm('Sponsor anda: ' + sponsor + ' (' + nama_sponsor + ')\r\nUpline anda: ' + upline + ' (' + nama_upline + ')\r\n\r\n Anda : ' + nama_anda + '\r\n Sedang Memasukkan ' + jumlah_hu + ' HU baru \r\n Posisi anda: ' + posisi + '\r\n\r\ \r\n\r\PASTIKAN DATA YANG ANDA INPUT BENAR. \r\n\r\nApakah Anda yakin akan data tersebut ?');
                            if (is_confirmation == true) {
                                return true;
                            } else {
                                return false;
                            }
                        } else {
                            return false;
                        }
                    }
                </script>        
            </div>

            <div class="col-md-4">
                <br>
                <center><img src="<?php echo $themes_url;?>/images/logo_gtl.png" style="margin-top: 15px;"></center>
                <br><hr><br>
                <h5><strong>PETUNJUK PENGISIAN :</strong></h5>
                <ul style="margin: 0; padding-left: 25px;">
                    <li>Isilah form berikut dengan benar dan sesuai kartu identitas (KTP/SIM/Passport) untuk mengaktifkan keanggotaan anda.</li>
                    <li>Isian yang bertanda <span class="required">*</span> wajib anda isi.</li>
                </ul>
                <hr>
                 <!--<a href="#" class="btn btn-default btn-block"><i class="glyphicon glyphicon-cog"></i>&nbsp;  Kontak Admin</a>--> 
            </div>
        </div>
    </div>
    <br>
</div>
<!-- widget Register -->