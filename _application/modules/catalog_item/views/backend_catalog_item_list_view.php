<h2>Data Katalog</h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>
<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->service_module_url; ?>/get_data',
        dataType: 'json',
        colModel: [
            { display: 'Gambar', name: 'catalog_item_image', width: 120, sortable: false, align: 'center', datasource: false },
            { display: 'Judul', name: 'catalog_item_title', width: 250, sortable: true, align: 'left' },
            { display: 'Deskripsi', name: 'catalog_item_description', width: 400, sortable: true, align: 'left' },
            { display: 'Jumlah Item', name: 'catalog_item_detail_count', width: 80, sortable: true, align: 'center' },
            { display: 'Aktif', name: 'catalog_item_is_active', width: 40, sortable: true, align: 'center' },
            { display: 'Detail Item', name: 'detail_item', width: 70, sortable: false, align: 'center', datasource: false },
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
            { display: 'Judul', name: 'catalog_item_title', type: 'text', isdefault: true },
            { display: 'Status Aktif', name: 'catalog_item_is_active', type: 'select', option: '1:Aktif|0:Tidak Aktif' },
        ],
        sortname: "catalog_item_id",
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