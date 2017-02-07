<h2>Data Pesan Admin</h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>
<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->service_module_url; ?>/get_message_admin_data',
        dataType: 'json',
        colModel: [
            { display: 'Pengirim', name: 'sender_network_code', width: 120, sortable: true, align: 'center' },
            { display: 'Nama Pengirim', name: 'sender_member_name', width: 150, sortable: true, align: 'left' },
            { display: 'Penerima', name: 'receiver_network_code', width: 120, sortable: true, align: 'center' },
            { display: 'Nama Penerima', name: 'receiver_member_name', width: 150, sortable: true, align: 'left' },
            { display: 'Subjek', name: 'message_subject', width: 250, sortable: true, align: 'left' },
            { display: 'Tanggal', name: 'message_input_datetime', width: 180, sortable: true, align: 'center' },
            { display: 'Status', name: 'message_is_read', width: 50, sortable: true, align: 'center', datasource: false },
            { display: 'Detail', name: 'detail_item', width: 50, sortable: false, align: 'center', datasource: false },
        ],
        buttons: [
            { display: 'Buat Pesan Baru', name: 'add', bclass: 'add', onpress: redirect, urlaction: '<?php echo $this->module_url; ?>/add' },
            { separator: true },
            { display: 'Pilih Semua', name: 'selectall', bclass: 'selectall', onpress: check },
            { separator: true },
            { display: 'Batalkan Pilihan', name: 'selectnone', bclass: 'selectnone', onpress: check },
            { separator: true },
            { display: 'Hapus', name: 'delete', bclass: 'delete', onpress: act_show, urlaction: '<?php echo $this->service_module_url; ?>/act_show' },
        ],
        searchitems: [
            { display: 'Pengirim', name: 'sender_network_code', type: 'text', isdefault: true },
            { display: 'Nama Pengirim', name: 'sender_member_name', type: 'text' },
            { display: 'Penerima', name: 'receiver_network_code', type: 'text' },
            { display: 'Nama Penerima', name: 'receiver_member_name', type: 'text' },
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