<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>

<form target="_blank" id="form_export" method="post" action="export_log_data">
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
        url: 'get_log_data',
        dataType: 'json',
        colModel: [
            { display: 'Tanggal', name: 'bonus_log_date', width: 140, sortable: true, align: 'center' },
            <?php
            foreach($arr_active_bonus as $bonus_item) {
            ?>
            { display: '<?php echo $bonus_item['label']; ?> (Rp)', name: '<?php echo 'bonus_log_' . $bonus_item['name']; ?>', width: <?php echo floor(strlen($bonus_item['label']) * 10); ?>, sortable: true, align: 'right' },
            <?php
            }
            ?>
            { display: 'Subtotal (Rp)', name: 'bonus_log_total', width: 130, sortable: true, align: 'right' },
        ],
        buttons_right: [
            { display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: export_data , urlaction:'export_log_data'},
        ],
        searchitems: [
            { display: 'Tanggal', name: 'bonus_log_date', type: 'date', isdefault: true },
        ],
        sortname: "bonus_log_date",
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