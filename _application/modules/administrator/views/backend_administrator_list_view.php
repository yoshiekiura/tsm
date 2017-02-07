<h2>Data Administrator</h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>
<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->service_module_url; ?>/get_data',
        dataType: 'json',
        colModel: [
            { display: 'Username', name: 'administrator_username', width: 200, sortable: true, align: 'left' },
            { display: 'Nama', name: 'administrator_name', width: 250, sortable: true, align: 'left' },
            { display: 'E-Mail', name: 'administrator_email', width: 150, sortable: true, align: 'left', hide: true },
            { display: 'Grup', name: 'administrator_group_title', width: 150, sortable: true, align: 'left' },
            { display: 'Login Terakhir', name: 'administrator_last_login', width: 180, sortable: true, align: 'center' },
            { display: 'Aktif', name: 'administrator_is_active', width: 40, sortable: true, align: 'center' },
            { display: 'Ubah', name: 'edit', width: 40, sortable: false, align: 'center', datasource: false },
            { display: 'Password', name: 'edit_password', width: 60, sortable: false, align: 'center', datasource: false },
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
            { display: 'Username', name: 'administrator_username', type: 'text', isdefault: true },
            { display: 'Nama', name: 'administrator_name', type: 'text' },
            { display: 'Grup', name: 'administrator_group_id', type: 'select', option: '<?php echo $administrator_group_grid_options; ?>' },
            { display: 'Login Terakhir', name: 'administrator_last_login', type: 'date' },
            { display: 'Status Aktif', name: 'administrator_is_active', type: 'select', option: '1:Aktif|0:Tidak Aktif' },
        ],
        sortname: "administrator_id",
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