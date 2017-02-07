<h2>Data Slider <?php echo $block_title; ?></h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>
<input type="hidden" id="block" value="<?php echo $block; ?>" />
<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->service_module_url; ?>/get_data/<?php echo $block; ?>',
        dataType: 'json',
        colModel: [
            { display: 'Gambar', name: 'slider_image', width: 120, sortable: false, align: 'center', datasource: false },
            { display: 'Judul', name: 'slider_title', width: 250, sortable: true, align: 'left' },
            { display: 'Aktif', name: 'slider_is_active', width: 40, sortable: true, align: 'center' },
            { display: 'Ubah', name: 'edit', width: 40, sortable: false, align: 'center', datasource: false },
        ],
        buttons: [
            { display: 'Tambah', name: 'add', bclass: 'add', onpress: redirect, urlaction: '<?php echo $this->module_url; ?>/add/<?php echo $block; ?>' },
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
            { display: 'Judul', name: 'slider_title', type: 'text', isdefault: true },
            { display: 'Status Aktif', name: 'slider_is_active', type: 'select', option: '1:Aktif|0:Tidak Aktif' },
        ],
        sortname: "slider_order_by",
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