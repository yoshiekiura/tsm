<table id="gridview" style="display:none;"></table>
<script>
    $("#gridview").flexigrid({
        url: 'get_data',
        dataType: 'json',
        colModel: [
            { display: 'Judul', name: 'downloads_title', width: 390, sortable: true, align: 'left' },
            { display: 'Deskripsi', name: 'downloads_description', width: 340, sortable: true, align: 'left' },
            { display: 'Tipe', name: 'downloads_icon', width: 50, sortable: false, align: 'center', datasource: false },
            { display: 'Ukuran File', name: 'downloads_filesize', width: 90, sortable: false, align: 'center' },
            { display: 'Download', name: 'downloads_link', width: 70, sortable: false, align: 'center' },
            { display: 'Tanggal', name: 'downloads_input_date', width: 120, sortable: true, align: 'center' },
        ],
        searchitems: [
            { display: 'Judul', name: 'downloads_title', type: 'text', isdefault: true },
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
    
    $(document).ready(function() {
        setInterval(function() {
            $('#gridview').flexReload();
        }, 300000);
        $.ajaxSetup({ cache: false });
    });
</script>