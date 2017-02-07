<table id="gridview" style="display:none;"></table>

<form target="_blank" id="form_export" method="post" action="export_sponsoring_data">
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
        url: 'get_sponsoring_data',
        dataType: 'json',
        colModel: [
            { display: 'Level', name: 'netgrow_sponsor_level', width: 50, sortable: true, align: 'center' },
            { display: 'Jalur Kaki', name: 'netgrow_sponsor_position_text', width: 90, sortable: true, align: 'center' },
            { display: 'Kode Member', name: 'downline_network_code', width: 90, sortable: true, align: 'center' },
            { display: 'Nama Member', name: 'downline_member_name', width: 150, sortable: true, align: 'left' },
            { display: 'Nama Alias', name: 'downline_member_nickname', width: 100, sortable: true, align: 'left', hide: true },
            { display: 'Aktif', name: 'downline_member_is_active', width: 40, sortable: true, align: 'center', hide: true },
            { display: 'No. Telp', name: 'downline_member_phone', width: 100, sortable: true, align: 'center', hide: true },
            { display: 'No. Handphone', name: 'downline_member_mobilephone', width: 100, sortable: true, align: 'center', hide: true },
            { display: 'Kota / Kabupaten', name: 'downline_member_city_name', width: 120, sortable: true, align: 'left', hide: true },
            { display: 'Propinsi', name: 'downline_member_province_name', width: 120, sortable: true, align: 'left', hide: true },
            { display: 'Regional', name: 'downline_member_region_name', width: 120, sortable: true, align: 'left', hide: true },
            { display: 'Negara', name: 'downline_member_country_name', width: 150, sortable: true, align: 'left', hide: true },
            { display: 'Frontline Kiri', name: 'downline_frontline_left_network_code', width: 100, sortable: true, align: 'center', hide: true },
            { display: 'Frontline Kanan', name: 'downline_frontline_right_network_code', width: 110, sortable: true, align: 'center', hide: true },
            { display: 'Tanggal', name: 'netgrow_sponsor_date', width: 120, sortable: true, align: 'center' },
        ],
        buttons_right: [
            { display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: export_data },
        ],
        searchitems: [
            { display: 'Level', name: 'netgrow_sponsor_level', type: 'text', isdefault: true },
            { display: 'Jalur Kaki', name: 'netgrow_sponsor_position', type: 'select', option: 'L:Kiri|R:Kanan' },
            { display: 'Kode Member', name: 'downline_network_code', type: 'text' },
            { display: 'Nama Member', name: 'downline_member_name', type: 'text' },
            { display: 'Nama Alias', name: 'downline_member_nickname', type: 'text' },
            { display: 'Kota / Kabupaten', name: 'downline_member_city_id', type: 'select', option: '<?php echo $city_grid_options; ?>' },
            { display: 'Propinsi', name: 'downline_member_province_id', type: 'select', option: '<?php echo $province_grid_options; ?>' },
            { display: 'Regional', name: 'downline_member_region_id', type: 'select', option: '<?php echo $region_grid_options; ?>' },
            { display: 'Negara', name: 'downline_member_country_id', type: 'select', option: '<?php echo $country_grid_options; ?>' },
            { display: 'Status Aktif', name: 'downline_member_is_active', type: 'select', option: '1:Aktif|0:Tidak Aktif' },
            { display: 'Tanggal', name: 'netgrow_sponsor_date', type: 'date' },
        ],
        sortname: "netgrow_sponsor_id",
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