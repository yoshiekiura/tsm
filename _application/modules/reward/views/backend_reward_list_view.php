<h2>Data Reward</h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>
<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->service_module_url;?>/get_data',
        dataType: 'json',
        colModel: [
            { display: 'Reward Image', name: 'reward_image', width: 120, sortable: false, align: 'center', datasource: false },
            { display: 'Bonus Reward', name: 'reward_bonus', width: 200, sortable: true, align: 'left' },            
            { display: 'Syarat Kaki Kiri', name: 'reward_cond_node_left', width: 100, sortable: true, align: 'center', datasource: false },
            { display: 'Syarat Kaki Kanan', name: 'reward_cond_node_right', width: 100, sortable: true, align: 'center' },
            { display: 'Nominal Reward', name: 'reward_bonus_value', width: 200, sortable: true, hide: true, align: 'left' },
            { display: 'Aktif', name: 'reward_is_active', width: 40, sortable: true, align: 'center' },//          
            { display: 'Ubah', name: 'edit', width: 40, sortable: false, align: 'center', datasource: false },
        ],
       buttons: [
            { display: 'Tambah', name: 'add', bclass: 'add', onpress: redirect, urlaction: '<?php echo $this->module_url; ?>/add' },
            { separator: true },
            { display: 'Pilih Semua', name: 'selectall', bclass: 'selectall', onpress: check },
            { separator: true },
            { display: 'Batalkan Pilihan', name: 'selectnone', bclass: 'selectnone', onpress: check },
            { separator: true },
            { display: 'Aktifkan', name: 'publish', bclass: 'publish', onpress: act_show, urlaction: '<?php echo $this->service_module_url; ?>/act_show' },
            { separator: true },
            { display: 'Non Aktifkan', name: 'unpublish', bclass: 'unpublish', onpress: act_show, urlaction: '<?php echo $this->service_module_url; ?>/act_show' },
            { separator: true },
            { display: 'Hapus', name: 'delete', bclass: 'delete', onpress: act_show, urlaction: '<?php echo $this->service_module_url; ?>/act_show' },
        ],
        searchitems: [
            { display: 'Status Aktif', name: 'reward_is_active', type: 'select', option: '1:Aktif|0:Tidak Aktif' },
        ],
        sortname: "reward_id",
        sortorder: "desc",
        usepager: true,
        title: '',
        useRp: true,
        rp: 100,
        showTableToggleBtn: false,
        showToggleBtn: true,
        width: 'auto',
        height: '500',
        resizable: false,
        singleSelect: false
    });
</script>