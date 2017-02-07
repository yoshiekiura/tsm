<h2>Approval Transfer Bonus</h2>
<div class="box">
    <div class="box-title">
        <div class="caption"><i class="icon-reorder"></i>Form Upload Excel Transfer Bonus</div>
    </div>
    <div class="box-body form">
        <?php echo form_open_multipart($form_action, array('class' => 'form-horizontal form-bordered')); ?>
        <?php echo form_hidden('uri_string', uri_string()); ?>
        <div class="form-body">

            <div class="form-group">
                <label class="control-label col-md-2">File Excel</label>
                <div class="col-md-10">
                    <div class="input-group" id="defaultrange">
                        <?php echo form_upload('file', '', 'size="50"'); ?>
                        <br /><small>(Format file: xls, xlsx)</small>
                    </div>
                </div>
            </div>

        </div>
        <div class="form-actions fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-offset-2 col-md-10">
                        <button name="insert" type="submit" class="btn btn-success"><i class="icon-upload"></i> Upload</button>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>