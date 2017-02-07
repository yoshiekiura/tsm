<h2>Data Testimoni</h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>
<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->service_module_url; ?>/get_data',
        dataType: 'json',
        colModel: [
            { display: 'Kategori', name: 'testimony_category_text', width: 100, sortable: true, align: 'center' },
            { display: 'Nama', name: 'testimony_name', width: 150, sortable: true, align: 'left' },
            { display: 'Isi Testimoni', name: 'testimony_content', width: 500, sortable: true, align: 'left' },
            { display: 'Tanggal', name: 'testimony_datetime', width: 160, sortable: true, align: 'center' },
            { display: 'Aktif', name: 'testimony_is_active', width: 40, sortable: true, align: 'center' },
            { display: 'Ubah', name: 'edit', width: 40, sortable: false, align: 'center', datasource: false },
        ],
        buttons: [
            { display: 'Tambah', name: 'add', bclass: 'add', onpress: redirect, urlaction: '<?php echo $this->module_url; ?>/add' },
            { separator: true },
            { display: 'Data Persetujuan', name: 'approve', bclass: 'testimony', onpress: redirect, urlaction: '<?php echo $this->module_url; ?>/approve' },
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
            { display: 'Kategori', name: 'testimony_category', type: 'select', option: 'public:Umum|member:Member', isdefault: true },
            { display: 'Nama', name: 'testimony_name', type: 'text' },
            { display: 'Tanggal', name: 'testimony_datetime', type: 'date' },
            { display: 'Status Aktif', name: 'testimony_is_active', type: 'select', option: '1:Aktif|0:Tidak Aktif' },
        ],
        sortname: "testimony_datetime",
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