<h2>Data Katalog Item Detail &raquo; <?php echo $catalog_item_title; ?></h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>
<input type="hidden" id="catalog_id" value="<?php echo $catalog_item_id; ?>" />
<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->service_module_url; ?>/get_item_data/<?php echo $catalog_item_id; ?>',
        dataType: 'json',
        colModel: [
            { display: 'Gambar', name: 'catalog_item_detail_image', width: 120, sortable: false, align: 'center', datasource: false },
            { display: 'Judul', name: 'catalog_item_detail_title', width: 250, sortable: true, align: 'left' },
            { display: 'Deskripsi', name: 'catalog_item_detail_description', width: 400, sortable: true, align: 'left' },
            { display: 'Aktif', name: 'catalog_item_detail_is_active', width: 40, sortable: true, align: 'center' },
            { display: 'Ubah', name: 'edit', width: 40, sortable: false, align: 'center', datasource: false },
        ],
        buttons: [
            { display: 'Tambah', name: 'add', bclass: 'add', onpress: redirect, urlaction: '<?php echo $this->module_url; ?>/item_add/<?php echo $catalog_item_id; ?>' },
            { separator: true },
            { display: 'Pilih Semua', name: 'selectall', bclass: 'selectall', onpress: check },
            { separator: true },
            { display: 'Batalkan Pilihan', name: 'selectnone', bclass: 'selectnone', onpress: check },
            { separator: true },
            { display: 'Aktifkan', name: 'publish', bclass: 'publish', onpress: act_show, urlaction: '<?php echo $this->service_module_url; ?>/act_item_show' },
            { separator: true },
            { display: 'Non Aktifkan', name: 'unpublish', bclass: 'unpublish', onpress: act_show, urlaction: '<?php echo $this->service_module_url; ?>/act_item_show' },
            { separator: true },
            { display: 'Up', name: 'up', bclass: 'sort_up', onpress: act_sort, urlaction: '<?php echo $this->service_module_url; ?>/act_item_show' },
            { separator: true },
            { display: 'Down', name: 'down', bclass: 'sort_down', onpress: act_sort, urlaction: '<?php echo $this->service_module_url; ?>/act_item_show' },
            { separator: true },
            { display: 'Hapus', name: 'delete', bclass: 'delete', onpress: act_show, urlaction: '<?php echo $this->service_module_url; ?>/act_item_show' },
        ],
        searchitems: [
            { display: 'Judul', name: 'catalog_item_detail_title', type: 'text', isdefault: true },
            { display: 'Status Aktif', name: 'catalog_item_detail_is_active', type: 'select', option: '1:Aktif|0:Tidak Aktif' },
        ],
        sortname: "catalog_item_detail_order_by",
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