<h2>Transfer Ewallet Member</h2>
<div class="box">
    <div class="box-title">
        <div class="caption"><i class="icon-reorder"></i>Form Transfer Ewallet</div>
    </div>
    <div class="box-body form">
        <?php echo form_open($form_action, array('class' => 'form-horizontal form-bordered')); ?>
        <?php echo form_hidden('uri_string', uri_string()); ?>
        <?php echo form_hidden('message_par_id', '0'); ?>
        
        <div class="form-body">
                       
            <div class="form-group">
                <label class="control-label col-md-2">Kode Member Yang Dituju</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('ewallet_transfer_log_network_id_transfer', (isset($this->arr_flashdata['input_kode_member'])) ? $this->arr_flashdata['input_kode_member'] : '', 'size="20" class="form-control"'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">Nominal Transfer</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('ewallet_transfer_log_value', (isset($this->arr_flashdata['input_nominal_transfer'])) ? $this->arr_flashdata['input_nominal_transfer'] : '', 'cols="60" rows="10" id="nominal" class="form-control"'); ?>
                    </div>
                </div>
            </div>
    
        <div class="form-group">
                <label class="control-label col-md-2">Pin Anda</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('pin', (isset($this->arr_flashdata['input_pin'])) ? $this->arr_flashdata['input_pin'] : '', 'cols="60" rows="10" class="form-control"'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-offset-2 col-md-10">
                        <button name="insert" type="submit" class="btn btn-success"><i class="icon-ok"></i> Transfer</button>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>js/numerik.js"></script>
<script>
    $(document).ready(function() {       
          $("#nominal").autoNumeric({aSep: '.', aDec: ','});
    });
</script>