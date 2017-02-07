<h2>Data Produk Item &raquo; <?php echo $product_name; ?></h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>
<input type="hidden" id="product_id" value="<?php echo $product_id; ?>" />
<script>
    $("#gridview").flexigrid({
        
        url: '<?php echo $this->service_module_url; ?>/get_item_data/<?php echo $product_id; ?>',
        dataType: 'json',
        colModel: [
            { display: 'Gambar', name: 'product_item_image', width: 120, sortable: false, align: 'center', datasource: false },
            { display: 'Nama', name: 'product_item_name', width: 100, sortable: true, align: 'left' },
            { display: 'Manfaat', name: 'product_item_name', width: 170, sortable: true, align: 'left' },
            { display: 'Komposisi', name: 'product_item_ingredient', width: 170, sortable: true, align: 'left' },
            { display: 'Penggunaan', name: 'product_item_how_to_use', width: 170, sortable: true, align: 'left' },
            { display: 'BPPOM', name: 'product_item_bpom', width: 120, sortable: true, align: 'left' },            
            { display: 'Harga', name: 'product_item_price', width: 120, sortable: true, align: 'right' },
            { display: 'Aktif', name: 'product_item_is_active', width: 40, sortable: true, align: 'center' },
            { display: 'Ubah', name: 'edit', width: 40, sortable: false, align: 'center', datasource: false },
        ],
        buttons: [
            { display: 'Tambah', name: 'add', bclass: 'add', onpress: redirect, urlaction: '<?php echo $this->module_url; ?>/item_add/<?php echo $product_id;?>' },
            { separator: true },
            { display: 'Pilih Semua', name: 'selectall', bclass: 'selectall', onpress: check },
            { separator: true },
            { display: 'Batalkan Pilihan', name: 'selectnone', bclass: 'selectnone', onpress: check },
            { separator: true },
            { display: 'Aktifkan', name: 'publish', bclass: 'publish',  onpress: act_show, urlaction: '<?php echo $this->service_module_url; ?>/act_item_show/<?php echo $product_id;?>' },
            { separator: true },
            { display: 'Non Aktifkan', name: 'unpublish', bclass: 'unpublish', onpress: act_show,  urlaction: '<?php echo $this->service_module_url; ?>/act_item_show/<?php echo $product_id;?>' },
            { separator: true },
            { display: 'Up', name: 'up', bclass: 'sort_up', onpress: act_show,  urlaction: '<?php echo $this->service_module_url; ?>/act_item_show/<?php echo $product_id;?>' },
            { separator: true },
            { display: 'Down', name: 'down', bclass: 'sort_down', onpress: act_show, urlaction: '<?php echo $this->service_module_url; ?>/act_item_show/<?php echo $product_id;?>' },
            { separator: true },
            { display: 'Hapus', name: 'delete', bclass: 'delete', onpress: act_show,  urlaction: '<?php echo $this->service_module_url; ?>/act_item_show/<?php echo $product_id;?>' },
        ],
        searchitems: [
            { display: 'Nama', name: 'product_item_name', type: 'text', isdefault: true },
            { display: 'Status Aktif', name: 'gallery_item_is_active', type: 'select', option: '1:Aktif|0:Tidak Aktif' },
        ],
        sortname: "product_item_order_by",
        sortorder: "asc",
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