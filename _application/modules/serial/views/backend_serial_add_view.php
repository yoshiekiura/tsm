<h2>Generate Serial</h2>
<div class="box">
    <div class="box-title">
        <div class="caption"><i class="icon-reorder"></i>Form Generate Serial</div>
    </div>
    <div class="box-body form">
        <?php echo form_open($form_action, array('class' => 'form-horizontal form-bordered')); ?>
        <?php echo form_hidden('uri_string', uri_string()); ?>
        <div class="form-body">

            <?php
            if ($serial_type_count > 1) {
                ?>
                <div class="form-group">
                    <label class="control-label col-md-2">Tipe Serial</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_dropdown('serial_type_id', $serial_type_options, (isset($this->arr_flashdata['input_serial_type_id'])) ? $this->arr_flashdata['input_serial_type_id'] : '', 'class="form-control"'); ?>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                echo '<input type="hidden" name="serial_type_id" value="' . $default_serial_type_id . '" />';
            }
            ?>

            <div class="form-group">
                <label class="control-label col-md-2">Jumlah Serial</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_input('count', '', 'size="10" class="form-control"'); ?>
                    </div>
                </div>
            </div>

        </div>
        <div class="form-actions fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-offset-2 col-md-10">
                        <button name="insert" type="submit" class="btn btn-success"><i class="icon-ok"></i> Generate</button>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>