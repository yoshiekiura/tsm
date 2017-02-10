<h2>Laporan Data Reward</h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>

<script>
    $("#gridview").flexigrid({
        url: '<?php echo $service_url ?>',
        dataType: 'json',
        colModel: [
            { display: 'No', name: 'no', width: 40, sortable: false, datasource: true, align: 'center' },
            { display: 'Kode Member', name: 'network_code', width: 100, sortable: true, align: 'left' },
            { display: 'Nama Member', name: 'member_name', width: 150, sortable: true, align: 'left' },
            { display: 'Bonus Reward', name: 'reward_qualified_reward_bonus', width: 150, sortable: true, align: 'left' },
            { display: 'Tanggal Claim', name: 'claim_datetime', width: 150, sortable: true, align: 'center' },
            { display: 'Syarat Kaki Kiri', name: 'reward_cond_node_left', width: 100, sortable: true, hide: true, align: 'center' },
            { display: 'Syarat Kaki Kanan', name: 'reward_cond_node_right', width: 100, sortable: true, hide: true, align: 'center' },
            { display: 'Kondisi Claim Kaki Kiri', name: 'reward_qualified_condition_node_left', width: 150, sortable: true, hide: true, align: 'center' },
            { display: 'Kondisi Claim Kaki Kanan', name: 'reward_qualified_condition_node_right', width: 150, sortable: true, hide: true, align: 'center' },
            { display: 'Status', name: 'reward_qualified_status', width: 120, sortable: true, align: 'center' },
            { display: 'Tanggal Diproses', name: 'process_date', width: 150, sortable: true, align: 'center' },
            { display: 'Nama Admin', name: 'administrator_name', width: 150, sortable: true, align: 'center' },
        ],
        buttons_right: [
            { display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '<?php echo $this->module_url; ?>/export_reward_data' },
        ],
        searchitems: [
            { display: 'Kode Member', name: 'network_code', type: 'text' },
            { display: 'Nama Member', name: 'member_name', type: 'text' },
            { display: 'Tanggal Claim', name: 'reward_qualified_date', type: 'date', isdefault: true },
            { display: 'Tanggal Diproses', name: 'process_date', type: 'date' },
            { display: 'Status', name: 'reward_qualified_status', type: 'select', option: 'approved:Approved|pending:Pending|rejected:Rejected' },
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