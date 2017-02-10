<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>

<script>
    $("#gridview").flexigrid({
        url: 'get_log_data',
        dataType: 'json',
        colModel: [
            { display: 'No', name: 'no', width: 50, sortable: false, datasource: true, align: 'center' },
            { display: 'Bonus Reward', name: 'reward_qualified_reward_bonus', width: 150, sortable: true, align: 'left' },
            { display: 'Tanggal Claim', name: 'reward_qualified_date', width: 120, sortable: true, align: 'center' },
            { display: 'Syarat Kaki Kiri', name: 'reward_cond_node_left', width: 100, sortable: true, align: 'center' },
            { display: 'Syarat Kaki Kanan', name: 'reward_cond_node_right', width: 100, sortable: true, align: 'center' },
            { display: 'Kondisi Claim Kaki Kiri', name: 'reward_qualified_condition_node_left', width: 150, sortable: true, align: 'center' },
            { display: 'Kondisi Claim Kaki Kanan', name: 'reward_qualified_condition_node_right', width: 150, sortable: true, align: 'center' },
            { display: 'Status', name: 'reward_qualified_status', width: 120, sortable: true, align: 'center' },
            { display: 'Tanggal diproses', name: 'process_date', width: 150, sortable: true, align: 'center' },
            { display: 'Nama Admin', name: 'administrator_name', width: 150, sortable: true, align: 'center' },
        ],
        // buttons_right: [
        //     { display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '<?php echo $this->module_url; ?>/export_log_data' },
        // ],
        searchitems: [
            { display: 'Tanggal Claim', name: 'reward_qualified_date', type: 'date', isdefault: true },
        ],
        sortname: "reward_qualified_id",
        sortorder: "desc",
        usepager: true,
        title: '',
        useRp: false,
        rp: 10,
        showTableToggleBtn: false,
        showToggleBtn: true,
        width: 'auto',
        height: '270',
        resizable: false,
        singleSelect: false
    });
</script>