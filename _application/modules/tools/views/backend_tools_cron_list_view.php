<h2>Data Cron</h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>
<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->service_module_url; ?>/get_data_cron',
        dataType: 'json',
        colModel: [
            { display: 'No.', name: 'no', width: 50, sortable: false, align: 'center' },
            { display: 'Nama Cron', name: 'cron_log_name', width: 180, sortable: true, align: 'center' },
            { display: 'Tanggal Cron', name: 'cron_log_date', width: 180, sortable: true, align: 'center' },
            { display: 'Tanggal Cron Berjalan', name: 'cron_log_run_datetime', width: 180, sortable: true, align: 'center', datasource: false },
        ],
        searchitems: [
            { display: 'Nama Cron', name: 'cron_log_name', type: 'text', isdefault: true },
            { display: 'Tanggal Cron', name: 'cron_log_date', type: 'date' },
        ],
        sortname: "cron_log_id",
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