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
echo (isset($this->arr_flashdata['message'])) ? $this->arr_flashdata['message'] : '';
?>

<div class="alert alert-info">
    <div class="titleInfo"><b>PETUNJUK PENGISIAN</b></div>
    <ul>
        <li>Isilah form berikut dengan benar dan sesuai kartu identitas (KTP/SIM/Passport) untuk mengaktifkan keanggotaan anda.</li>
        <li>Isian yang bertanda <span class="required">*</span> wajib anda isi.</li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Form Registrasi</h3>
            </div>
            <form name="frm_reg" action="<?php echo base_url() . $form_action; ?>" method="post" class="form-horizontal form-bordered" id="registerHere">
                <input type="hidden" name="uri_string" value="<?php echo uri_string(); ?>" />
                <input type="text" name="reg_new_sponsor" id="reg_new_sponsor" value="<?php echo (isset($this->arr_flashdata['input_reg_new_sponsor'])) ? $this->arr_flashdata['input_reg_new_sponsor'] : $reg_sponsor; ?>">
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label col-md-2">ID Sponsor <span class="required">*</span></label>
                        <div class="col-md-10">
                            <div class="input-group" id="defaultrange">
                                <input placeholder="ID Sponsor..." type="text" name="reg_sponsor" id="reg_sponsor" value="<?php echo (isset($this->arr_flashdata['input_reg_sponsor'])) ? $this->arr_flashdata['input_reg_sponsor'] : $reg_sponsor; ?>" size="20" class="form-control" rel="popover" data-content="ID Sponsor" data-original-title="ID Sponsor" required /><br /><span id="reg_nama_sponsor"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">ID Upline <span class="required">*</span></label>
                        <div class="col-md-10">
                            <div class="input-group" id="defaultrange">
                                <input placeholder="ID Upline..." type="text" name="reg_upline" id="reg_upline" value="<?php echo (isset($this->arr_flashdata['input_reg_upline'])) ? $this->arr_flashdata['input_reg_upline'] : $reg_upline; ?>" size="20" class="form-control" rel="popover" data-content="ID Upline" data-original-title="ID Upline" required /><br /><span id="reg_nama_upline"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">Posisi <span class="required">*</span></label>
                        <div class="col-md-10">
                            <div class="input-group" id="defaultrange">
                                <label style="display:inline-block; float:left; margin-right:15px;">
                                    <input type="radio" name="reg_posisi" id="reg_posisi_kiri" value="kiri" style="margin-top:-3px;" <?php echo (isset($this->arr_flashdata['input_reg_posisi'])) ? (($this->arr_flashdata['input_reg_posisi'] == 'kiri') ? 'checked' : '') : ($reg_posisi == 'kiri') ? 'checked' : 'disabled'; ?>>
                                    <span>Kiri&nbsp;&nbsp;</span>
                                </label>
                                <label style="display:inline-block; float:left; margin-right:15px;">
                                    <input type="radio" name="reg_posisi" id="reg_posisi_kanan" value="kanan" style="margin-top:-3px;" <?php echo (isset($this->arr_flashdata['input_reg_posisi'])) ? (($this->arr_flashdata['input_reg_posisi'] == 'kanan') ? 'checked' : '') : ($reg_posisi == 'kanan') ? 'checked' : 'disabled'; ?>>
                                    <span>Kanan</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">Paket Join <span class="required">*</span></label>
                        <div class="col-md-10">
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
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">Serial - PIN <span class="required">*</span></label>
                        <div class="col-md-10">
                            <p style="color: #eea236;">Masukkan nomor serial beserta pin aktivasi</p>
                            <div class="row-serial" id="row-serial">
                                <div class="items">
                                    <div class="col-md-6" style = "padding-left:0px;">
                                        <label >Nomor Serial 1 <span class="required">*</span></label>
                                        <input type="text" class="form-control" id="serial1" name ="reg_serial[1]" placeholder="Nomor Serial ..." value="<?php echo (isset($this->arr_flashdata['input_reg_serial'][1])) ? $this->arr_flashdata['input_reg_serial'][1] : ''; ?>">
                                    </div>

                                    <div class="col-md-6" style = "padding-left:0px;">
                                        <label >PIN 1 <span class="required">*</span></label>
                                        <input type="text" class="form-control" id="pin1" name ="reg_pin[1]" placeholder="PIN ..." value="<?php echo (isset($this->arr_flashdata['input_reg_pin'][1])) ? $this->arr_flashdata['input_reg_pin'][1] : ''; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">Password <span class="required">*</span></label>
                        <div class="col-md-10">
                            <div class="input-group" id="defaultrange">
                                <input placeholder="Password..." type="password" name="reg_password" id="reg_password" value="<?php echo (isset($this->arr_flashdata['input_reg_password'])) ? $this->arr_flashdata['input_reg_password'] : ''; ?>" size="40" class="form-control" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">Ulangi Password <span class="required">*</span></label>
                        <div class="col-md-10">
                            <div class="input-group" id="defaultrange">
                                <input placeholder="Masukkan kembali password..." type="password" name="reg_repassword" id="reg_repassword" value="<?php echo (isset($this->arr_flashdata['input_reg_repassword'])) ? $this->arr_flashdata['input_reg_repassword'] : ''; ?>"  class="form-control" size="40" required />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">Nama Lengkap <span class="required">*</span></label>
                        <div class="col-md-10">
                            <div class="input-group" id="defaultrange">
                                <input placeholder="Nama Lengkap..." type="text" name="reg_nama" id="reg_nama" value="<?php echo (isset($this->arr_flashdata['input_reg_nama'])) ? $this->arr_flashdata['input_reg_nama'] : $reg_nama; ?>" class="form-control" size="60" /><br><small>sesuaikan dengan rekening anda</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">No. Handphone <span class="required">*</span></label>
                        <div class="col-md-10">
                            <div class="input-group" id="defaultrange">
                                <input placeholder="No. Handphone..." type="text" name="reg_handphone" id="reg_handphone" value="<?php echo (isset($this->arr_flashdata['input_reg_handphone'])) ? $this->arr_flashdata['input_reg_handphone'] : $reg_handphone; ?>" size="20" maxlength="15" class="form-control"  />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">Nama Bank</label>
                        <div class="col-md-10">
                            <div class="input-group" id="defaultrange">
                                <select name="reg_id_bank" class="form-control">
                                    <option value="0" <?php echo (!isset($this->arr_flashdata['input_reg_id_bank'])) ? 'selected="selected"' : ''; ?>>N/A</option>
                                    <?php
                                    if ($query_bank->num_rows() > 0) {
                                        foreach ($query_bank->result() as $row_bank) {
                                            $selected = (isset($this->arr_flashdata['input_reg_id_bank'])) ? (($this->arr_flashdata['input_reg_id_bank'] == $row_bank->bank_id) ? 'selected="selected"' : '') : ($reg_id_bank == $row_bank->bank_id) ? 'selected="selected"' : '';
                                            echo '<option value="' . $row_bank->bank_id . '" ' . $selected . '>' . $row_bank->bank_name . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">Nama Nasabah</label>
                        <div class="col-md-10">
                            <div class="input-group" id="defaultrange">
                                <input placeholder="Nama Nasabah..." type="text" name="reg_nasabah_bank" id="reg_nasabah_bank" value="<?php echo (isset($this->arr_flashdata['input_reg_nasabah_bank'])) ? $this->arr_flashdata['input_reg_nasabah_bank'] : $reg_nasabah_bank; ?>" size="60" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">No. Rekening <span class="required">*</span></label>
                        <div class="col-md-10">
                            <div class="input-group" id="defaultrange">
                                <input placeholder="Nomor Rekening..." type="text" name="reg_no_rekening_bank" id="reg_no_rekening_bank" value="<?php echo (isset($this->arr_flashdata['input_reg_no_rekening_bank'])) ? $this->arr_flashdata['input_reg_no_rekening_bank'] : $reg_no_rekening_bank; ?>" size="20" maxlength="20" class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-md-offset-2 col-md-10">
                        <button name="register" type="submit" value="true" onclick="return confirmation();" class="btn btn-success"><i class="icon-ok"></i> Aktifkan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    var new_sponsor_name = false, new_sponsor_code = false;
    var delay = (function(){
        var timer = 0;
        return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        };
    })();

    $(document).ready(function() {
        check_member_data('reg_nama_sponsor', $("#reg_sponsor").val());
        check_member_data('reg_nama_upline', $("#reg_upline").val());
        check_no_rekening('reg_no_rekening_bank', $("#reg_no_rekening_bank").val());

        $("#reg_sponsor").blur(function() {
            check_member_data('reg_nama_sponsor', $("#reg_sponsor").val());
        });

        $("#reg_upline").blur(function() {
            check_member_data('reg_nama_upline', $("#reg_upline").val());
        });

        $("#reg_repassword, #reg_password").blur(function() {
            $(".help-block.password_msg").remove();    
            if ($("#reg_password").val() != '') {
                if ($("#reg_password").val() != $("#reg_repassword").val()) {
                    $("#reg_repassword, #reg_password").parent().addClass('has-error');
                    $("#reg_repassword").after('<span class="help-block password_msg">Password dan Konfirmasi Password tidak sama.</span>');
                    toggle_submit('disabled');
                } else {
                    $("#reg_repassword, #reg_password").parent().removeClass('has-error').addClass('has-success');
                    $(".help-block.password_msg").remove();    
                    toggle_submit('enable');
                }
            } else {
                toggle_submit('disabled');
                $("#reg_password").parent().addClass('has-error');
                $("#reg_password").after('<span class="help-block password_msg">Password harus diisi.</span>');
            }
        });

        $("#reg_no_rekening_bank").keyup(function() {
            if ($(this).val() != '') {
                toggle_submit('disabled');

                $(this).parent().removeClass('has-error').removeClass('has-success');
                $('#info_change_sponsor').remove();
                $(".help-block.no_rek_msg").remove();    
                $(this).after('<span class="help-block no_rek_msg">Sedang mencari nomor rekening yang sama..</span>');
                
                delay(function(){
                    check_no_rekening('reg_no_rekening_bank', $("#reg_no_rekening_bank").val());
                }, 2000);
            }
        });

        $("#reg_no_rekening_bank, #reg_handphone").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                 // Allow: Ctrl+A, Command+A
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
                 // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                     // let it happen, don't do anything
                     return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

        // $("#reg_nama").blur(function() {
        //     $("#reg_nasabah_bank").val($(this).val());
        // });
    });

    function toggle_submit(status) {
        if (status=='enable') {
            $('button[name=register]').removeAttr('disabled');
        } else {
            $('button[name=register]').attr('disabled','disabled');
        }
    }

    function check_member_data(id, code) {
        if (code.length > 0) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('voffice/registration/get_member_name'); ?>',
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

    function check_no_rekening(id, no_rek) {
        if (no_rek.length > 0) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('voffice/registration/check_rekening'); ?>',
                data: {no_rek: no_rek},
                dataType: 'json',
                async: false,
                beforeSend: function() {
                    $(".help-block.no_rek_msg").remove();
                    $("#" + id).after('<span class="help-block no_rek_msg">Sedang mencari nomor rekening yang sama..</span>');
                },
                success: function(results) {
                    $(".help-block.no_rek_msg").remove();
                    if (results.status=='success') {
                        $("#" + id).parent().removeClass('has-error').addClass('has-success');
                        if (results.change == 'yes') {
                            new_sponsor_code = results.sponsor_network_code;
                            new_sponsor_name = results.sponsor_name;
                            var htmlinfo = '<div class="col-md-10 col-md-push-2" id="info_change_sponsor"><br>' +
                            '<div class="alert alert-info"> <div class="titleInfo"><b>Perubahan Sponsor</b></div>' +
                                '<ul> <li>Sponsor akan berubah dari <strong>' + $("#reg_nama_sponsor").html() + ' (' + $("#reg_sponsor").val().toUpperCase() + ')</strong>' +
                                ' menjadi <strong>' + results.sponsor_name + ' (' + results.sponsor_network_code + ')</strong></li> </ul>' +
                            '</div> </div>';
                            $("#" + id).closest('.form-group').append(htmlinfo);
                            $("#" + id).after('<span class="help-block no_rek_msg">'+results.message+'</span>');

                            // set new sponsor
                            set_new_sponsor(new_sponsor_code);

                        } else if (results.change == 'no') {
                            $("#" + id).after('<span class="help-block no_rek_msg">'+results.message+'</span>');

                            // revert back to old sponsor
                            set_new_sponsor($("#reg_sponsor").val());
                        }
                        toggle_submit('enable');
                    } else if(results.status == 'failed') {
                        new_sponsor_code = false;
                        new_sponsor_name = false;
                        $(".help-block.no_rek_msg").remove();
                        $("#" + id).parent().addClass('has-error');
                        $("#" + id).after('<span class="help-block no_rek_msg">'+results.message+'</span>');

                        // revert back to old sponsor
                        set_new_sponsor($("#reg_sponsor").val());
                    }
                }
            });
        }
    }

    function set_new_sponsor(code) {
        $('#reg_new_sponsor').val(code);
    }

    function confirmation() {
        if (new_sponsor_code !== false) {
            var sponsor = new_sponsor_code;
        } else {
            var sponsor = $("#reg_sponsor").val().toUpperCase();
        }
        var upline = $("#reg_upline").val().toUpperCase();
        var nama_anda = $("#reg_nama").val().toUpperCase();
        var jumlah_hu = $('input[name=reg_paket]:checked').val()
        var posisi = $('input[name=reg_posisi]:checked').val()
        if (new_sponsor_name !== false) {
            var nama_sponsor = new_sponsor_name;
        } else {
            var nama_sponsor = $("#reg_nama_sponsor").html();
        }
        var nama_upline = $("#reg_nama_upline").html();

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

<?php if(isset($this->arr_flashdata['input_reg_serial'])) {
    ?>

    <script type="text/javascript">
    $(document).ready(function() {
    var selected_paket = $("input[type='radio'][name='reg_paket']:checked").val();

    $('#row-serial .items').remove();
    var i = 1;
    var reg_serial = <?php echo json_encode($this->arr_flashdata['input_reg_serial']) ;?>;
    console.log(reg_serial[1]);
    var newRow = $("<div class='row-serial' id='row-serial'>");

    for (i = 1; i <= selected_paket; i++) {
        var cols = "";
        cols += '<div class="items">';
        cols += '<div class="col-md-6" style = "padding-left:0px;">';
        cols += '<label for="serial' + i + '">Nomor Serial ' + i + ' <span class="required">*</span></label>';
        cols += '<input type="text" class="form-control" id="serial' + i + '" name ="reg_serial[' + i + ']" placeholder="nomor serial ..." value="'+reg_serial[i]+'" >';
        cols += '</div>';

        cols += '<div class="col-md-6" style = "padding-left:0px;">';
        cols += '<label for="pin' + i + '">PIN ' + i + ' <span class="required">*</span></label>';
        cols += '<input type="text" class="form-control" id="pin' + i + '" name ="reg_pin[' + i + ']" placeholder="pin ..." >';
        cols += '</div>';
        cols += '</div>';

        newRow.append(cols);
        $("#row-serial").append(newRow);
    }
    ;
});
</script>
<?php
}
?>
