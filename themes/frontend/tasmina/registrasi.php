<?php include('template/header_2.php'); ?>

<!-- Main -->
<div id="main-container">
    <div id="title-bar">
        <div class="container">
            <h3 style="text-align: center;margin-top: 15px;">Registrasi Member</h3>
        </div>
    </div>

    <div class="container">
        <!-- widget Register -->
        <div class="panel panel-default panel-gtl" id="widget-register">
            <div class="panel-heading">
                <h4 style="padding-bottom: 0px;"><small>PENDAFTARAN</small>MEMBER BARU</h4>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8">
                        <form role="form" class="reg-form">
                            <h5 class="divider"><strong>Data Jaringan</strong></h5>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">ID Sponsor <span class="required">*</span></label>
                                <div class="col-sm-7">
                                    <input placeholder="ID Sponsor..." type="text" name="reg_sponsor" id="reg_sponsor" value="" class="form-control input-sm" rel="popover" data-content="ID Sponsor" data-original-title="ID Sponsor" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">ID Upline <span class="required">*</span></label>
                                <div class="col-sm-7">
                                    <input placeholder="ID Upline..." type="text" name="reg_upline" id="reg_upline" value="" class="form-control input-sm" rel="popover" data-content="ID Upline" data-original-title="ID Upline" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Posisi <span class="required">*</span></label>
                                <div class="col-sm-7">
                                    <label class="radio-inline">
                                        <input type="radio" name="reg_posisi" id="reg_posisi_kiri" value="kiri" checked="">
                                        <span>Kiri&nbsp;&nbsp;</span>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="reg_posisi" id="reg_posisi_kanan" value="kanan">
                                        <span>Kanan</span>
                                    </label>
                                </div>
                            </div>
                            <br>

                            <h5 class="divider"><strong>Data Kartu</strong></h5>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nomor Serial <span class="required">*</span></label>
                                <div class="col-sm-7">
                                    <input placeholder="Nomor Serial..." type="text" name="reg_serial" id="reg_serial" value="" maxlength="12" class="form-control input-sm" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">PIN <span class="required">*</span></label>
                                <div class="col-sm-7">
                                    <input placeholder="PIN..." type="password" name="reg_pin" id="reg_pin" value="" maxlength="6" class="form-control input-sm" required="">
                                </div>
                            </div>
                            <br>

                            <h5 class="divider"><strong>Data Pribadi</strong></h5>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nama Lengkap <span class="required">*</span></label>
                                <div class="col-sm-7">
                                    <input placeholder="Nama Lengkap..." type="text" name="reg_nama" id="reg_nama" value="" class="form-control input-sm" required=""><small>sesuaikan dengan rekening anda</small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Email</label>
                                <div class="col-sm-7">
                                    <input placeholder="Email..." type="text" name="reg_email" id="reg_email" value="" maxlength="50" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">No. Handphone <span class="required">*</span></label>
                                <div class="col-sm-7">
                                    <input placeholder="No. Handphone..." type="text" name="reg_handphone" id="reg_handphone" value="" maxlength="12" class="form-control input-sm" required="">
                                </div>
                            </div>
                            <br>

                            <h5 class="divider"><strong>Data Bank</strong><br><small>Kosongkan jika Anda belum mempunyai Rekening Bank</small></h5>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nama Bank</label>
                                <div class="col-sm-7">
                                    <select name="reg_id_bank" class="form-control input-sm">
                                        <option value="0" selected="selected">N/A</option>
                                        <option value="15">ABN Amro Bank</option><option value="10">Bank Artha Graha</option><option value="1">Bank BCA</option><option value="9">Bank BII</option><option value="30">Bank BNI Syariah</option><option value="5">Bank BRI</option><option value="28">Bank BTN</option><option value="32">Bank BTN Syariah</option><option value="26">Bank BTPN</option><option value="16">Bank Buana Indonesia</option><option value="14">Bank Bukopin</option><option value="24">Bank Bumi Arta</option><option value="17">Bank Bumiputera</option><option value="7">Bank CIMB Niaga</option><option value="18">Bank Danamon</option><option value="12">Bank Ekonomi</option><option value="19">Bank Ganesha</option><option value="33">Bank Krut</option><option value="2">Bank Mandiri</option><option value="29">Bank Mandiri Syariah</option><option value="13">Bank Maspion</option><option value="25">Bank Mayapada</option><option value="20">Bank Mega</option><option value="31">Bank Mega Syariah</option><option value="6">Bank Muamalat</option><option value="3">Bank Niaga</option><option value="11">Bank NISP</option><option value="27">Bank Panin</option><option value="8">Bank Permata</option><option value="21">Bank UOB Buana</option><option value="4">BNI</option><option value="23">Citibank</option><option value="22">HSBC</option>                        
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Cabang</label>
                                <div class="col-sm-7">
                                    <input placeholder="Cabang Bank..." type="text" name="reg_cabang_bank" id="reg_cabang_bank" value="" maxlength="20" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Kota Bank</label>
                                <div class="col-sm-7">
                                    <input placeholder="Kota Bank..." type="text" name="reg_kota_bank" id="reg_kota_bank" value="" maxlength="20" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nama Nasabah</label>
                                <div class="col-sm-7">
                                    <input placeholder="Nama Nasabah..." type="text" name="reg_nasabah_bank" id="reg_nasabah_bank" value="" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="col-sm-4 control-label">No. Rekening</label>
                                <div class="col-sm-7">
                                    <input placeholder="Nomor Rekening..." type="text" name="reg_no_rekening_bank" id="reg_no_rekening_bank" value="" maxlength="20" class="form-control input-sm">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">&nbsp;</label>
                                <div class="col-sm-7">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="fa fa-check-square-o"></i>&nbsp; Aktifkan Akun Saya</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-4">
                        <br>
                        <center><img src="images/logo.png" style="margin-top: 5px;height: 100px;"></center>
                        <br><hr><br>
                        <h5><strong>PETUNJUK PENGISIAN :</strong></h5>
                        <ul style="margin: 0; padding-left: 25px;">
                            <li>Isilah form berikut dengan benar dan sesuai kartu identitas (KTP/SIM/Passport) untuk mengaktifkan keanggotaan anda.</li>
                            <li>Isian yang bertanda <span class="required">*</span> wajib anda isi.</li>
                        </ul>
                        <hr>
                        <a href="#" class="btn btn-default btn-block"><i class="glyphicon glyphicon-cog"></i>&nbsp;  Kontak Admin</a>
                    </div>
                </div>
            </div>
            <br>
        </div>
        <!-- widget Register -->
    </div>
    <!-- end container -->

    <div id="section-2">
        <div id="widget_fullpromo">
            <div class="container">
                <img src="uploads/promo/promo-2.jpg" class="promo_img">
                <div class="promo_link">
                    <h4>Daftarkan diri anda berhaji dan umroh bersama kami.<a href="#" class="btn btn-default">DAFTAR SEKARANG</a></h4>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Main -->

<?php include('template/footer.php'); ?>