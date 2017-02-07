<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>

<form target="_blank" id="form_export" method="post" action="export_transfer_data">
    <input id="export_column_name" type="hidden" name="column[name]" value="" />
    <input id="export_column_title" type="hidden" name="column[title]" value="" />
    <input id="export_column_show" type="hidden" name="column[show]" value="" />
    <input id="export_column_align" type="hidden" name="column[align]" value="" />
    <input id="export_sortname" type="hidden" name="params[sortname]" value="" />
    <input id="export_sortorder" type="hidden" name="params[sortorder]" value="" />
    <input id="export_query" type="hidden" name="params[query]" value="" />
    <input id="export_optionused" type="hidden" name="params[optionused]" value="" />
    <input id="export_option" type="hidden" name="params[option]" value="" />
    <input id="export_date_start" type="hidden" name="params[date_start]" value="" />
    <input id="export_date_end" type="hidden" name="params[date_end]" value="" />
    <input id="export_qtype" type="hidden" name="params[qtype]" value="" />
</form>

<script>
    $("#gridview").flexigrid({
        url: 'get_transfer_data',
        dataType: 'json',
        colModel: [
            { display: 'Kode Transfer', name: 'bonus_transfer_code', width: 150, sortable: true, align: 'center' },
            { display: 'Periode', name: 'bonus_transfer_datetime', width: 180, sortable: true, align: 'center' },
            { display: 'Kategori', name: 'bonus_transfer_category_label', width: 140, sortable: true, align: 'center' },
            { display: 'Total Transfer (Rp)', name: 'bonus_transfer_nett', width: 130, sortable: true, align: 'right' },
            { display: 'Status', name: 'bonus_transfer_status_label', width: 100, sortable: true, align: 'center' },
            { display: 'Keterangan', name: 'bonus_transfer_note', width: 250, sortable: true, align: 'left' },
            { display: 'Detail', name: 'detail', width: 50, sortable: false, align: 'center', datasource: false },
            { display: 'Cetak', name: 'print', width: 50, sortable: false, align: 'center', datasource: false },
        ],
        buttons_right: [
            { display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '<?php echo $this->module_url; ?>/export_transfer_data'  },
        ],
        searchitems: [
            { display: 'Kode Transfer', name: 'bonus_transfer_code', type: 'text', isdefault: true },
            { display: 'Periode', name: 'bonus_transfer_datetime', type: 'date' },
            { display: 'Status', name: 'bonus_transfer_status', type: 'select', option: 'pending:PENDING|success:SUKSES|failed:GAGAL' },
            { display: 'Kategori', name: 'bonus_transfer_category', type: 'select', option: '<?php echo $transfer_category_grid_options; ?>' },
        ],
        sortname: "bonus_transfer_id",
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
    
    function export_transfer_data(){
         window.location.href = "<?php echo base_url();?>voffice/bonus/export_transfer_data";
    }
    
</script>