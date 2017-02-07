<h2>Laporan Aktivasi Member</h2>
<table id="gridview" style="display:none;"></table>

<script>
    $("#gridview").flexigrid({
        url: 'get_member_activation_data',
        dataType: 'json',
        colModel: [
            { display: 'Tanggal', name: 'serial_user_date', width: 150, sortable: true, align: 'center' },
            { display: 'Jumlah Aktivasi', name: 'serial_user_count', width: 150, sortable: true, align: 'right' },
        ],
        searchitems: [
            { display: 'Tanggal', name: 'serial_user_date', type: 'date', isdefault: true },
        ],
        sortname: "serial_user_date",
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
    
    $(document).ready(function() {
        setInterval(function() {
            $('#gridview').flexReload();
        }, 300000);
        $.ajaxSetup({ cache: false });
    });
</script>