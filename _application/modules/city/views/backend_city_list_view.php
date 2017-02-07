<h2>Data Kota / Kabupaten</h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>
<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->service_module_url; ?>/get_data',
        dataType: 'json',
        colModel: [
            { display: 'Nama Kota / Kabupaten', name: 'city_name', width: 200, sortable: true, align: 'left' },
            { display: 'Propinsi', name: 'province_name', width: 200, sortable: true, align: 'left' },
            { display: 'Regional', name: 'region_name', width: 200, sortable: true, align: 'left' },
            { display: 'Aktif', name: 'city_is_active', width: 40, sortable: true, align: 'center' },
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
            { display: 'Nama Kota / Kabupaten', name: 'city_name', type: 'text', isdefault: true },
            { display: 'Propinsi', name: 'province_id', type: 'select', option: '<?php echo $province_grid_options; ?>' },
            { display: 'Regional', name: 'region_id', type: 'select', option: '<?php echo $region_grid_options; ?>' },
            { display: 'Status Aktif', name: 'city_is_active', type: 'select', option: '1:Aktif|0:Tidak Aktif' },
        ],
        sortname: "city_id",
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