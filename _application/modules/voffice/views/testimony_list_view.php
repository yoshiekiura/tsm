<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>
<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->module_url; ?>/get_data',
        dataType: 'json',
        colModel: [
            { display: 'Isi Testimoni', name: 'testimony_content', width: 500, sortable: true, align: 'left' },
            { display: 'Tanggal', name: 'testimony_datetime', width: 160, sortable: true, align: 'center' },
            { display: 'Ubah', name: 'edit', width: 40, sortable: false, align: 'center', datasource: false },
        ],
        buttons: [
            { display: 'Kirim Testimoni', name: 'add', bclass: 'add', onpress: redirect, urlaction: '<?php echo $this->module_url; ?>/add' },
            { separator: true },
            { display: 'Hapus', name: 'delete', bclass: 'delete', onpress: act_show, urlaction: '<?php echo $this->module_url; ?>/act_show' },
        ],
        searchitems: [
            { display: 'Tanggal', name: 'testimony_datetime', type: 'date', isdefault: true },
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