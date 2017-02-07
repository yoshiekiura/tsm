<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>

<script>
    $("#gridview").flexigrid({
        url: 'get_data',
        dataType: 'json',
        colModel: [
            { display: 'Tanggal', name: 'ewallet_product_log_datetime', width: 150, sortable: true, align: 'left' },
            { display: 'Nominal', name: 'ewallet_product_log_value', width: 120, sortable: true, align: 'right' },
            { display: 'Type', name: 'ewallet_product_log_type', width: 80, sortable: true, align: 'left' },
            { display: 'Keterangan', name: 'ewallet_product_log_note', width: 500, sortable: false, align: 'left' },
        ],
        sortname: "ewallet_product_log_datetime",
        sortorder: "desc",
        usepager: true,
        title: 'Saldo Ewallet Anda : Rp <?php echo $this->function_lib->set_number_format($saldo_ewallet); ?>,-',
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