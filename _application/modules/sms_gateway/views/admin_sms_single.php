<h2>Kirim Pesan SMS</h2>
<br>
<form action="" method="post" name="admin_form" enctype="multipart/form-data">
    <label>Member ID</label><br>
    <div class="col-lg-6"><input type="text" name="network_mid" value="" class="form-control" onblur="check_member_hp('no_hp', this.value);">Untuk multiple, pisahkan dengan koma ( <b>, </b>)</div>
    <div style="padding-bottom: 10px; clear: both"></div>
    <label>No HP<font color="red">*</font></label><br>
    <div class="col-lg-6"><input type="text" name="sms_gateway_mobilephone" id="no_hp" class="form-control" /><?php echo form_error('sms_gateway_mobilephone');?></div>
    <div style="padding-bottom: 10px; clear: both"></div>
    <label>Isi Pesan<font color="red">*</font></label><br>
    <div class="col-lg-6"><textarea name="sms_gateway_content" cols="30" rows="4" class="form-control" id="isi_sms"></textarea> <?php echo form_error('sms_gateway_content'); ?><span id="hitung"></span> karakter digunakan</div>
    <div style="padding-bottom: 10px; clear: both"></div>
    <div class="form-actions fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" name="save" value="Kirim" class="btn btn-success"><span><i class="icon-ok"></i>Kirim</span></button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
function check_member_hp(id, code) {
    if(code.length > 0) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>backend/sms_gateway/cek_hp/',
            data: 'code=' + code,
            dataType: 'json',
            async: false,
            success: function(member_hp) {
                if(member_hp.length > 0) {
                    var result_text = member_hp;
                } else {
                    var result_text = 'Tidak Ditemukan';
                }
                $("#" + id).val(result_text);
            }
        });
    }
}
</script>
<script type="text/javascript">
$("#isi_sms").keyup(function() {
    var len = this.value.length;
    $('#hitung').text(len);

});
</script>