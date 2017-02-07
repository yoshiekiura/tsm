<h2>Data Halaman Informasi Member</h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>
<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->service_module_url; ?>/get_data',
        dataType: 'json',
        colModel: [
            { display: 'Judul', name: 'page_dashboard_title', width: 200, sortable: false, align: 'left' },
            { display: 'Konten', name: 'page_dashboard_content', width: 500, sortable: false, align: 'left' },
            { display: 'Aktif', name: 'page_dashboard_is_active', width: 40, sortable: false, align: 'center' },
            { display: 'Ubah', name: 'edit', width: 40, sortable: false, align: 'center', datasource: false },
        ],
        buttons: [
//            { display: 'Tambah', name: 'add', bclass: 'add', onpress: add },
//            { separator: true },
//            { display: 'Pilih Semua', name: 'selectall', bclass: 'selectall', onpress: check },
//            { separator: true },
//            { display: 'Batalkan Pilihan', name: 'selectnone', bclass: 'selectnone', onpress: check },
            { display: 'Aktifkan', name: 'publish', bclass: 'publish', onpress: act_show, urlaction: '<?php echo $this->service_module_url; ?>/act_show' },
            { separator: true },
            { display: 'Non Aktifkan', name: 'unpublish', bclass: 'unpublish', onpress: act_show, urlaction: '<?php echo $this->service_module_url; ?>/act_show' },
            { separator: true },
//            { display: 'Hapus', name: 'delete', bclass: 'delete', onpress: act_show },
        ],
        searchitems: [
            { display: 'Judul', name: 'page_dashboard_title', type: 'text', isdefault: true },
            { display: 'Konten', name: 'page_dashboard_content', type: 'text', isdefault: true },
            { display: 'Status Aktif', name: 'page_dashboard_is_active', type: 'select', option: '1:Aktif|0:Tidak Aktif' },
        ],
        sortname: "page_dashboard_id",
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