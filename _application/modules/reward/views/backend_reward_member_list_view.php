<h2>APPROVAL CLAIM REWARD</h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>

<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->service_module_url ?>/get_data_member',
        dataType: 'json',
        colModel: [
            {display: 'Kode Member', name: 'network_code', width: 120, sortable: false, align: 'center', datasource: false},
            {display: 'Nama member', name: 'member_name', width: 200, sortable: false, align: 'left'},
            {display: 'Reward Item', name: 'reward_qualified_reward_bonus', width: 120, sortable: false, align: 'left'},
            {display: 'No Hp', name: 'member_mobilephone', width: 100, sortable: false, align: 'left'},
            {display: 'Nominal Reward', name: 'reward_qualified_reward_value', width: 80, sortable: false, hide: true, align: 'left'},
            {display: 'Tanggal Claim', name: 'reward_qualified_date', width: 150, sortable: false, align: 'left'},
        ],
        buttons: [
            {display: 'Approve', name: 'approve', bclass: 'accept', onpress: act_show, urlaction: '<?php echo $this->service_module_url; ?>/act_show'},
            {separator: true},
            {display: 'Reject', name: 'reject', bclass: 'delete', onpress: act_show, urlaction: '<?php echo $this->service_module_url; ?>/act_show'},
            {separator: true},
            {display: 'Pilih Semua', name: 'selectall', bclass: 'selectall', onpress: check},
            {separator: true},
            {display: 'Batalkan Pilihan', name: 'selectnone', bclass: 'selectnone', onpress: check},
            {separator: true},
        ],
        buttons_right: [
            {display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '<?php echo $this->service_module_url; ?>/export_data'},
        ],
        searchitems: [
            {display: 'Kode Member', name: 'network_code', type: 'text', isdefault: true},
            {display: 'Nama member', name: 'member_name', type: 'text'},
        ],
        sortname: "reward_qualified_id",
        sortorder: "desc",
        usepager: true,
        useRp: true,
        title: '',
        showTableToggleBtn: false,
        showToggleBtn: true,
        width: 'auto',
        height: '400',
        resizable: false,
        singleSelect: false
    });
//
</script>