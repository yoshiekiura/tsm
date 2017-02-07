<h2>Data Produk</h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>
<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->service_module_url; ?>/get_data',
        dataType: 'json',
        colModel: [
            { display: 'Gambar', name: 'product_image', width: 100, sortable: false, align: 'center', datasource: false },
            { display: 'Nama Produk', name: 'product_name', width: 200, sortable: true, align: 'left' },
            { display: 'Deskripsi Produk', name: 'product_description', width: 250, sortable: true, align: 'left' },
            { display: 'Harga Member', name: 'product_price_member', width: 120, sortable: true, align: 'center' },
            { display: 'Harga Non Member', name: 'product_price_non', width: 120, sortable: true, align: 'center' },
            { display: 'Jumlah Item', name: 'product_item_count', width: 100, sortable: true, align: 'center' },
            { display: 'Detail Item', name: 'detail_item', width: 80, sortable: true, align: 'center' },
            { display: 'Aktif', name: 'product_is_active', width: 40, sortable: true, align: 'center' },            
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
            { display: 'Hapus', name: 'delete', bclass: 'delete', onpress: act_show, urlaction: '<?php echo $this->service_module_url; ?>/act_show' },
        ],
        searchitems: [
            { display: 'Judul', name: 'product_name', type: 'text', isdefault: true },
            { display: 'Status Aktif', name: 'product_is_active', type: 'select', option: '1:Aktif|0:Tidak Aktif' },
        ],
        sortname: "product_id",
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