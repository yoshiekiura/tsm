<h2>Kirim SMS Broadcast</h2>
<br>
<form action="" method="post" name="admin_form" enctype="multipart/form-data">
    <label>Isi Pesan<font color="red">*</font></label><br>
    <div class="col-lg-6"><textarea name="sms_gateway_content" cols="30" rows="4" class="form-control" id="isi_sms"></textarea> <?php echo form_error('sms_gateway_content');?><span id="hitung"></span> karakter digunakan</div>
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
<script type="text/javascript">
$("#isi_sms").keyup(function() {
    var len = this.value.length;
    $('#hitung').text(len);

});
</script>