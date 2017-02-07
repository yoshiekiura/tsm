<h2>Data Grup Administrator</h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>
<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->service_module_url; ?>/get_data',
        dataType: 'json',
        colModel: [
            { display: 'Nama Grup', name: 'administrator_group_title', width: 300, sortable: true, align: 'left' },
            <?php if ($this->session->userdata('administrator_group_type') == 'superuser'): ?>
            { display: 'Tipe Grup', name: 'administrator_group_type', width: 150, sortable: true, align: 'center' },
            <?php endif; ?>
            { display: 'Aktif', name: 'administrator_group_is_active', width: 40, sortable: true, align: 'center' },
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
            { display: 'Nama Grup', name: 'administrator_group_title', type: 'text', isdefault: true },
            <?php if ($this->session->userdata('administrator_group_type') == 'superuser'): ?>
            { display: 'Tipe Grup', name: 'administrator_group_type', type: 'select', option: 'superuser:Superuser|administrator:Administrator' },
            <?php endif; ?>
            { display: 'Status Aktif', name: 'administrator_group_is_active', type: 'select', option: '1:Aktif|0:Tidak Aktif' },
        ],
        sortname: "administrator_group_id",
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