<h2>Buat Pesan Baru</h2>
<div class="box">
    <div class="box-title">
        <div class="caption"><i class="icon-reorder"></i>Form Buat Pesan Baru</div>
    </div>
    <div class="box-body form">
        <?php echo form_open($form_action, array('class' => 'form-horizontal form-bordered')); ?>
        <?php echo form_hidden('uri_string', uri_string()); ?>
        <?php echo form_hidden('message_par_id', '0'); ?>
        
        <div class="form-body">

            <div class="form-group">
                <label class="control-label col-md-2">Member ID</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('network_code', (isset($this->arr_flashdata['input_net_code'])) ? $this->arr_flashdata['input_net_code'] : '', 'size="40" class="form-control"'); ?>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-2">Judul</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('message_title', (isset($this->arr_flashdata['input_title'])) ? $this->arr_flashdata['input_title'] : '', 'size="40" class="form-control"'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">Isi Pesan</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_textarea('content', (isset($this->arr_flashdata['input_content'])) ? $this->arr_flashdata['input_content'] : '', 'cols="60" rows="10" class="form-control"'); ?>
                    </div>
                </div>
            </div>

        </div>
        <div class="form-actions fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-offset-2 col-md-10">
                        <button name="insert" type="submit" class="btn btn-success"><i class="icon-ok"></i> Kirim</button>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>