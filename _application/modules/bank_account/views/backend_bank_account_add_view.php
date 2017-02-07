<h2>Tambah Data Rekening</h2>
<div class="box">
    <div class="box-title">
        <div class="caption"><i class="icon-reorder"></i>Form Tambah Data Rekening</div>
    </div>
    <div class="box-body form">
        <?php echo form_open($form_action, array('class' => 'form-horizontal form-bordered')); ?>
        <?php echo form_hidden('uri_string', uri_string()); ?>
        <div class="form-body">

            <div class="form-group">
                <label class="control-label col-md-2">Bank</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_dropdown('bank_id', $bank_options, (isset($this->arr_flashdata['input_bank_id'])) ? $this->arr_flashdata['input_bank_id'] : '', 'class="form-control"'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">Nama Rekening</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('name', (isset($this->arr_flashdata['input_name'])) ? $this->arr_flashdata['input_name'] : '', 'size="40" class="form-control"'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">No. Rekening</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('no', (isset($this->arr_flashdata['input_no'])) ? $this->arr_flashdata['input_no'] : '', 'size="40" class="form-control"'); ?>
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