<h2>Data Rekening</h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>
<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->service_module_url; ?>/get_data',
        dataType: 'json',
        colModel: [
            { display: 'Bank', name: 'bank_name', width: 150, sortable: true, align: 'center' },
            { display: 'Nama Rekening', name: 'bank_account_name', width: 300, sortable: true, align: 'left' },
            { display: 'No. Rekening', name: 'bank_account_no', width: 150, sortable: true, align: 'center' },
            { display: 'Aktif', name: 'bank_account_is_active', width: 40, sortable: true, align: 'center' },
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
            { display: 'Bank', name: 'bank_id', type: 'select', option: '<?php echo $bank_grid_options; ?>' },
            { display: 'Nama Rekening', name: 'bank_account_name', type: 'text', isdefault: true },
            { display: 'No. Rekening', name: 'bank_account_no', type: 'text', isdefault: true },
            { display: 'Status Aktif', name: 'bank_account_is_active', type: 'select', option: '1:Aktif|0:Tidak Aktif' },
        ],
        sortname: "bank_account_id",
        sortorder: "desc",
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