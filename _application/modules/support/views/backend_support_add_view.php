<h2>Tambah Online Support</h2>
<div class="box">
    <div class="box-title">
        <div class="caption"><i class="icon-reorder"></i>Form Tambah Online Support</div>
    </div>
    <div class="box-body form">
        <?php echo form_open($form_action, array('class' => 'form-horizontal form-bordered')); ?>
        <?php echo form_hidden('uri_string', uri_string()); ?>
        <div class="form-body">

            <div class="form-group">
                <label class="control-label col-md-2">Nama</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('name', (isset($this->arr_flashdata['input_name'])) ? $this->arr_flashdata['input_name'] : '', 'size="60" class="form-control"'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">No. Telp</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('phone', (isset($this->arr_flashdata['input_phone'])) ? $this->arr_flashdata['input_phone'] : '', 'size="60" class="form-control"'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">Yahoo! Messenger ID</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('ym', (isset($this->arr_flashdata['input_ym'])) ? $this->arr_flashdata['input_ym'] : '', 'size="60" class="form-control"'); ?>
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