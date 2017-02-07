<h2>History Pasangan</h2>
<table id="gridview" style="display:none;"></table>

<form target="_blank" id="form_export" method="post" action="export_match_data">
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
    <input id="export_total_data" type="hidden" name="params[total_data]" value="" />
    <input id="export_rp" type="hidden" name="params[rp]" value="" />
    <input id="export_page" type="hidden" name="params[page]" value="" />
</form>

<script>
    $("#gridview").flexigrid({
        url: 'get_match_data',
        dataType: 'json',
        colModel: [
            { display: 'Jumlah Pasangan', name: 'netgrow_match_value', width: 130, sortable: true, align: 'center' },
            { display: 'Tanggal', name: 'netgrow_match_date', width: 120, sortable: true, align: 'center' },
        ],
        buttons_right: [
            { display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: export_data },
        ],
        searchitems: [
            { display: 'Tanggal', name: 'netgrow_match_date', type: 'date', isdefault: true },
        ],
        sortname: "netgrow_match_id",
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