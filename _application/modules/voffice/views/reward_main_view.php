<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>

<script>
    $("#gridview").flexigrid({
        url: 'get_data',
        dataType: 'json',
        colModel: [
            { display: 'Kaki Kiri', name: 'reward_cond_node_left', width: 90, sortable: true, align: 'center' },
            { display: 'Kaki Kanan', name: 'reward_cond_node_right', width: 90, sortable: true, align: 'center' },
            { display: 'Bonus Reward', name: 'reward_bonus', width: 250, sortable: true, align: 'left' },
            { display: 'Qualified', name: 'reward_is_qualified', width: 80, sortable: true, align: 'center' },
            { display: 'Tanggal Qualified', name: 'reward_qualified_date', width: 140, sortable: true, align: 'center' },
        ],
        sortname: "reward_cond_node_left",
        sortorder: "asc",
        usepager: true,
        title: 'JUMLAH JARINGAN ANDA: <?php echo $arr_node['left']; ?> KIRI&nbsp;&nbsp;&middot;&middot;&middot;&nbsp;&nbsp;<?php echo $arr_node['right']; ?> KANAN',
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