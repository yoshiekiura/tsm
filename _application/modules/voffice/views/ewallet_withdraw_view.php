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

<?php echo (isset($this->arr_flashdata['message'])) ? $this->arr_flashdata['message'] : ''; ?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Form <?php echo $page_title; ?></h3>
            </div>
            <form role="form" method="post" id="form_<?php echo $transfer_type;?>" action ="<?php echo $form_action;?>">
                <input type="hidden" name="uri_string" value="<?php echo uri_string();?>" />
                <input type="hidden" name="type" value="<?php echo $transfer_type;?>" />
                <div class="box-body">
                    <?php if($transfer_type =='member') { ?>
                    <div class="form-group">
                        <label>Kode Member Penerima</label>
                        <?php echo form_input('receive_network_code', (isset($this->arr_flashdata['input_kode_member'])) ? $this->arr_flashdata['input_kode_member'] : '', 'class="form-control networkcode" placeholder="Masukkan Kode Member Penerima"'); ?> 
                        <p class="help-block"><span class="member_name"></span></p>
                    </div>
                    <?php } ?>
                    <div class="form-group">
                        <label>Nominal Transfer</label>
                        <?php echo form_input('ewallet_transfer_value', (isset($this->arr_flashdata['input_nominal_transfer'])) ? $this->arr_flashdata['input_nominal_transfer'] : '', 'class="form-control nominal" placeholder="Masukkan Nominal Transfer"'); ?>
                    </div>
                    <div class="form-group">
                        <label>Validasi PIN</label>
                        <?php echo form_input('pin', (isset($this->arr_flashdata['input_pin'])) ? $this->arr_flashdata['input_pin'] : '', 'class="form-control pin" placeholder="Masukkan Kode PIN Anda"'); ?>
                    </div>
                </div>
                <div class="box-footer">
                    <button name="submit" type="submit" value="true" class="btn btn-success btnTransfer"><i class="icon-ok"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>js/numerik.js"></script>
<script type="text/javascript">
   $(document).ready(function(){
    $(".nominal").autoNumeric({aSep: '.', aDec: ','});
    $(".networkcode").blur(function () {
        check_member_data('member_name', $(".networkcode").val());
    });

});

   function check_member_data(id, code) {
    if (code.length > 0) {
        $.ajax({
            type: 'POST',
            url: '../get_member_name',
            data: 'code=' + code,
            dataType: 'json',
            async: false,
            success: function (member_name) {
                if (member_name.length > 0) {
                    var result_add_class = 'text_success';
                    var result_remove_class = 'text_error';
                    var result_text = member_name;
                } else {
                    var result_add_class = 'text_error';
                    var result_remove_class = 'text_success';
                    var result_text = 'Tidak Ditemukan';
                }
                $("." + id).html(result_text).removeClass(result_remove_class).addClass(result_add_class);

                console.log(result_text);
            }
        });
    }
}

function confirmation() {

    var form_id = document.getElementsByTagName("form")[0].getAttribute("id");      
    
    var tx_value = $(".nominal").val();
    
    if(form_id == 'form_member'){ 
        var receiver_name = $(".member_name").html().toUpperCase();
        var receiver_code = $(".networkcode").val().toUpperCase();  
        if (receiver_code.length > 0 && receiver_name.length > 0 && tx_value.length > 0) {
            var is_confirmation = confirm('Anda akan melakukan Transfer ke Member : ' + receiver_code + ' (' + receiver_name + ') Sebesar Rp. '+tx_value+'?');
            if (is_confirmation == true) {
                return true;
            } else {
                return false;
            }
        } else{
            return false;
        }
    }else if(form_id == 'form_payment'){
        if(tx_value.length > 0) {
            var is_confirmation = confirm('Anda akan melakukan Deposit ke Payment Sebesar : ' + tx_value +' ?');
             if (is_confirmation == true) {
                    return true;
                } else {
                    return false;
                }
            }else{
                return false;
            }
        
    }
    else return false;
    

    
}
</script>
