<h2>Tambah Anggota Grup</h2>
<div class="box">
    <div class="box-title">
        <div class="caption"><i class="icon-reorder"></i>Form Tambah Anggota Grup</div>
    </div>
    <div class="box-body form">
        <?php echo form_open($form_action, array('class' => 'form-horizontal form-bordered')); ?>
        <?php echo form_hidden('uri_string', uri_string()); ?>
        <div class="form-body">

            <div class="form-group">
                <label class="control-label col-md-2">Kode Member</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('code', (isset($this->arr_flashdata['input_code'])) ? $this->arr_flashdata['input_code'] : '', 'size="15" class="form-control"'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">PIN Member</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('pin', (isset($this->arr_flashdata['input_pin'])) ? $this->arr_flashdata['input_pin'] : '', 'size="5" class="form-control"'); ?>
                        <br /><small>PIN Member yang akan Anda tambahkan</small>
                    </div>
                </div>
            </div>

        </div>
        <div class="form-actions fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-offset-2 col-md-10">
                        <button name="insert" type="submit" class="btn btn-success"><i class="icon-ok"></i> Simpan</button>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>