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
</script>