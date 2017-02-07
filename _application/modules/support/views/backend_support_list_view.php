<h2>Data Online Support</h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>
<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->service_module_url; ?>/get_data',
        dataType: 'json',
        colModel: [
            { display: 'Nama', name: 'support_name', width: 250, sortable: false, align: 'left' },
            { display: 'No. Telp', name: 'support_phone', width: 200, sortable: false, align: 'left' },
            { display: 'Yahoo! Messenger ID', name: 'support_ym', width: 200, sortable: false, align: 'left' },
            { display: 'Aktif', name: 'support_is_active', width: 40, sortable: false, align: 'center' },
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
            { display: 'Up', name: 'up', bclass: 'sort_up', onpress: act_sort, urlaction: '<?php echo $this->service_module_url; ?>/act_show' },
            { separator: true },
            { display: 'Down', name: 'down', bclass: 'sort_down', onpress: act_sort, urlaction: '<?php echo $this->service_module_url; ?>/act_show' },
            { separator: true },
            { display: 'Hapus', name: 'delete', bclass: 'delete', onpress: act_show, urlaction: '<?php echo $this->service_module_url; ?>/act_show' },
        ],
        searchitems: [
            { display: 'Nama', name: 'support_name', type: 'text', isdefault: true },
            { display: 'No. Telp', name: 'support_phone', type: 'text', isdefault: true },
            { display: 'Yahoo! Messenger ID', name: 'support_ym', type: 'text', isdefault: true },
            { display: 'Status Aktif', name: 'support_is_active', type: 'select', option: '1:Aktif|0:Tidak Aktif' },
        ],
        sortname: "support_order_by",
        sortorder: "asc",
        usepager: true,
        title: '',
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