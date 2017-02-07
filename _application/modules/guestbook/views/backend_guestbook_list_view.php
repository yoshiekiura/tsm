<h2>Buku Tamu</h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>

<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->service_module_url; ?>/get_data',
        dataType: 'json',
        colModel: [
            { display: 'Nama', name: 'guestbook_name', width: 150, sortable: true, align: 'left' },
            { display: 'Subjek', name: 'guestbook_subject', width: 150, sortable: true, align: 'left' },
            { display: 'Tanggal', name: 'guestbook_input_datetime', width: 180, sortable: true, align: 'center' },
            { display: 'Dibaca', name: 'guestbook_is_read', width: 50, sortable: true, align: 'center' },
            { display: 'Detail', name: 'detail_item', width: 50, sortable: false, align: 'center', datasource: false },
        ],
        buttons: [
            { display: 'Pilih Semua', name: 'selectall', bclass: 'selectall', onpress: check },
            { separator: true },
            { display: 'Batalkan Pilihan', name: 'selectnone', bclass: 'selectnone', onpress: check },
            { separator: true },
            { display: 'Hapus', name: 'delete', bclass: 'delete', onpress: act_show, urlaction: '<?php echo $this->service_module_url; ?>/act_show' },
        ],
        searchitems: [
            { display: 'Nama', name: 'guestbook_name', type: 'text', isdefault: true },
            { display: 'Subjek', name: 'guestbook_subject', type: 'text' },
            { display: 'Tanggal', name: 'guestbook_input_datetime', type: 'date' },
        ],
        sortname: "guestbook_input_datetime",
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