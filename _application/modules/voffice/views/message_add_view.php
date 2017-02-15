<?php
$message_type = (isset($this->arr_flashdata['input_type'])) ? $this->arr_flashdata['input_type'] : '';
switch ($message_type) {
    case 'admin':
        $admin_checked = true;
        $member_checked = false;
        $network_code_readonly = 'readonly';
        break;

    default:
        $admin_checked = false;
        $member_checked = true;
        $network_code_readonly = '';
        break;
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Form Tambah Pesan</h3>
            </div>
            <?php echo form_open($form_action, array('class' => 'form-horizontal form-bordered')); ?>
            <?php echo form_hidden('uri_string', uri_string()); ?>
            <?php echo form_hidden('message_par_id', '0'); ?>
            <div class="box-body">

                <div class="form-group">
                    <label class="control-label col-md-2">Ditujukan ke</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <div class="radio"><label><?php echo form_radio(array('name' => 'type', 'value' => 'member', 'checked' => $member_checked, 'onclick' => 'this.form.network_code.removeAttribute(\'readonly\', false); this.form.network_code.value=\'\'; this.form.network_code.focus();')); ?>&nbsp;Member</label></div>
                            <div class="radio"><label><?php echo form_radio(array('name' => 'type', 'value' => 'admin', 'checked' => $admin_checked, 'onclick' => 'this.form.network_code.setAttribute(\'readonly\', true); this.form.network_code.value=\'Admin\';')); ?>&nbsp;Admin</label></div>

                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Kode Member</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('network_code', (isset($this->arr_flashdata['input_network_code'])) ? $this->arr_flashdata['input_network_code'] : '', $network_code_readonly . ' size="40" class="form-control"'); ?>
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

                <div class="form-group" style="border-bottom:1px solid #eee;">
                    <div class="col-md-9">
                        <div class="input-group" id="defaultrange">
                            <h4>Konfirmasi PIN</h4>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">PIN Serial</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('validate_pin', (isset($this->arr_flashdata['input_validate_pin'])) ? $this->arr_flashdata['input_validate_pin'] : '', 'size="30" class="form-control"'); ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="box-footer">
                <div class="col-md-offset-2 col-md-10">
                    <button name="insert" type="submit" class="btn btn-success"><i class="icon-ok"></i> Kirim</button>
                </div>
            </div>

            <?php echo form_close(); ?>

        </div>
    </div>
</div>
