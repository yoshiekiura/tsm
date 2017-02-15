<div id="response_message" style="display:none;"></div>

<table id="gridview" style="display:none;"></table>
<style>td{padding: 7px 5px;vertical-align: middle;}</style>

<script>
    $("#gridview").flexigrid({
        url: '<?php echo $service_url ?>',
        dataType: 'json',
        colModel: [
            { display: 'No', name: 'no', width: 50, sortable: false, align: 'center' },
            { display: 'Bonus Reward', name: 'reward_bonus', width: 250, sortable: true, align: 'left' },
            { display: 'Syarat Kaki Kiri', name: 'reward_cond_node_left', width: 110, sortable: true, align: 'center' },
            { display: 'Syarat Kaki Kanan', name: 'reward_cond_node_right', width: 110, sortable: true, align: 'center' },
            { display: 'Action', name: 'action', width: 150, sortable: false, align: 'center' },
        ],
        sortname: "reward_cond_node_left",
        sortorder: "asc",
        usepager: true,
        title: 'JUMLAH TITIK REWARD ANDA : <?php echo $arr_node['left']; ?> KIRI &middot;&middot;&middot; <?php echo $arr_node['right']; ?> KANAN',
        useRp: true,
        rp: 10,
        showTableToggleBtn: false,
        showToggleBtn: true,
        width: 'auto',
        height: '270',
        resizable: false,
        singleSelect: false
    });

    $(document).ready(function() {
        $('#gridview').on('click', 'a.btn-claim', function() {
            var href = $(this).attr('href');
            $('#formValidate').attr('action', href);
            $('#confirmPin').modal('show');
            return false;
        });
    });
</script>

<div class="modal fade" id="confirmPin">
    <div class="modal-dialog modal-sm modal-info">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Konfirmasi PIN Serial
                </h4>
            </div>
            <form action="" method="post" id="formValidate">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="validate_pin" class="control-label">PIN Serial</label>
                        <input type="text" name="validate_pin" id="validate_pin" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Claim</button>
                </div>
            </form>
        </div>
    </div>
</div>