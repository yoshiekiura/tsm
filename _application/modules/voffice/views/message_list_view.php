<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>
<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->module_url; ?>/get_message_data',
        dataType: 'json',
        colModel: [
            { display: 'Kode Member', name: 'network_code', width: 120, sortable: true, align: 'center' },
            { display: 'Nama', name: 'member_name', width: 200, sortable: true, align: 'left' },
            { display: 'Subjek', name: 'message_subject', width: 300, sortable: true, align: 'left' },
            { display: 'Tanggal', name: 'message_input_datetime', width: 180, sortable: true, align: 'center' },
            { display: 'Status', name: 'message_is_read', width: 50, sortable: true, align: 'center', datasource: false },
            { display: 'Detail', name: 'detail_item', width: 50, sortable: false, align: 'center', datasource: false },
        ],
        buttons: [
            { display: 'Kirim Pesan Baru', name: 'add', bclass: 'add', onpress: redirect, urlaction: '<?php echo $this->module_url; ?>/add' },
            { separator: true },
            { display: 'Pilih Semua', name: 'selectall', bclass: 'selectall', onpress: check },
            { separator: true },
            { display: 'Batalkan Pilihan', name: 'selectnone', bclass: 'selectnone', onpress: check },
            { separator: true },
            { display: 'Hapus', name: 'delete', bclass: 'delete', onpress: act_show, urlaction: '<?php echo $this->module_url; ?>/act_show' },
        ],
        searchitems: [
            { display: 'Kode Member', name: 'network_code', type: 'text', isdefault: true },
            { display: 'Nama', name: 'member_name', type: 'text' },
            { display: 'Subjek', name: 'message_subject', type: 'text' },
            { display: 'Tanggal', name: 'message_input_datetime', type: 'date' },
        ],
        sortname: "message_input_datetime",
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