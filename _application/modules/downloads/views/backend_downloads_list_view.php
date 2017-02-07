<h2>Data Download File</h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>
<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->service_module_url; ?>/get_data',
        dataType: 'json',
        colModel: [
            { display: 'Judul', name: 'downloads_title', width: 400, sortable: false, align: 'left' },
            { display: 'Deskripsi', name: 'downloads_description', width: 400, sortable: false, align: 'left', hide: true },
            { display: 'Lokasi', name: 'downloads_location_text', width: 80, sortable: false, align: 'center' },
            { display: 'Tipe', name: 'downloads_icon', width: 50, sortable: false, align: 'center', datasource: false },
            { display: 'Format File', name: 'downloads_file_ext', width: 80, sortable: false, align: 'center' },
            { display: 'Ukuran File', name: 'downloads_filesize', width: 100, sortable: false, align: 'center' },
            { display: 'Tanggal', name: 'downloads_input_datetime', width: 180, sortable: true, align: 'center' },
            { display: 'Jumlah Diunduh', name: 'downloads_count', width: 110, sortable: true, align: 'center' },
            { display: 'Aktif', name: 'downloads_is_active', width: 40, sortable: true, align: 'center' },
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
            { display: 'Judul', name: 'downloads_title', type: 'text', isdefault: true },
            { display: 'Lokasi', name: 'downloads_location', type: 'select', option: 'public:Umum|member:Member' },
            { display: 'Status Aktif', name: 'downloads_is_active', type: 'select', option: '1:Aktif|0:Tidak Aktif' },
        ],
        sortname: "downloads_id",
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