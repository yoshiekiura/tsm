<h2>Data Harga Serial</h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>

<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->service_module_url; ?>/get_price_data',
        dataType: 'json',
        colModel: [
            { display: 'Tipe', name: 'serial_type_label', width: 150, sortable: true, align: 'center' },
            { display: 'Harga (Rp)', name: 'serial_type_price', width: 120, sortable: true, align: 'right' },
            { display: 'Ubah Harga', name: 'edit', width: 80, sortable: false, align: 'center', datasource: false },
        ],
        searchitems: [
            { display: 'Tipe', name: 'serial_type_id', type: 'select', option: '<?php echo $serial_type_grid_options; ?>' },
        ],
        sortname: "serial_type_id",
        sortorder: "asc",
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