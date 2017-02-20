<h2>Cek Data</h2>
<div class="box">
    <div class="box-title">
        <div class="caption"><i class="icon-reorder"></i> Form Cek Data</div>
    </div>
    <div class="box-body form">

        <form method="POST" action="<?php echo $form_action ?>" > 
            <?php echo form_hidden('uri_string', uri_string()); ?>
            <div class="form-body">
                <div class="form-group">
                    <label class="control-label col-md-2">Input Kode Member</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <?php echo form_input('member_code', (isset($this->arr_flashdata['input_member_code'])) ? $this->arr_flashdata['input_member_code'] : '', 'size="40" class="form-control"'); ?>
                        </div>
                    </div>
                </div>
                <br>
            </div>
            <div class="form-actions fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-offset-2 col-md-10">
                            <button name="insert" type="submit" class="btn btn-success"><i class="icon-ok"></i> Cek Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php if ($this->session->flashdata('data_send')): ?>
<?php $data_send = $this->session->flashdata('data_send'); ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Hasil Pencarian</h3>
        </div>
        <table class="table table-bordered">
            <tbody>
                <tr> <th width="28%">Network ID</th> <td><?php echo $data_send['network_id'] ?></td> </tr>
                <tr> <th width="28%">Member</th> <td><?php echo $data_send['network_code'] ?></td> </tr>
                <tr> <th width="28%">Sponsor</th> <td><?php echo empty($data_send['sponsor_network_code']) ? '-' : $data_send['sponsor_network_code']; ?></td> </tr>
                <tr> <th width="28%">Upline</th> <td><?php echo empty($data_send['upline_network_code']) ? '-' : $data_send['upline_network_code']; ?></td> </tr>
            </tbody>
        </table>
        <hr style="margin: 0; height: 3px; background: #eee; ">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan="2" width="28%">Bonus Item</th>
                    <th colspan="3" class="text-center" width="72%">Bonus</th>
                </tr>
                <tr>
                    <th class="text-right" width="24%">Terjadi</th>
                    <th class="text-right" width="24%">Dibayar</th>
                    <th class="text-right" width="24%">Saldo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data_send['arr_bonus_active'] as $bonus): ?>
                <tr>
                    <td><strong><?php echo $bonus['label']; ?></strong></td>
                    <td class="text-right">Rp. <?php echo $this->function_lib->set_number_format($data_send['data_bonus']->{'bonus_' . $bonus['name'] . '_acc'}); ?></td>
                    <td class="text-right">Rp. <?php echo $this->function_lib->set_number_format($data_send['data_bonus']->{'bonus_' . $bonus['name'] . '_paid'}); ?></td>
                    <td class="text-right">Rp. <?php echo $this->function_lib->set_number_format($data_send['data_bonus']->{'bonus_' . $bonus['name'] . '_saldo'}); ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
<?php endif ?>