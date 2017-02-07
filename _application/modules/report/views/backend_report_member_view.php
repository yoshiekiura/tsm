<h2>Laporan Data Member</h2>
<table id="gridview" style="display:none;"></table>

<script>
    $("#gridview").flexigrid({
        url: 'get_member_data',
        dataType: 'json',
        colModel: [
            { display: 'Kode Member', name: 'network_code', width: 90, sortable: true, align: 'center' },
            { display: 'Nama Member', name: 'member_name', width: 150, sortable: true, align: 'left' },
            { display: 'Nama Alias', name: 'member_nickname', width: 100, sortable: true, align: 'left', hide: true },
            { display: 'Posisi', name: 'network_position_text', width: 70, sortable: true, align: 'center', hide: true },
            { display: 'Kode Sponsor', name: 'sponsor_network_code', width: 90, sortable: true, align: 'center' },
            { display: 'Nama Sponsor', name: 'sponsor_member_name', width: 150, sortable: true, align: 'left', hide: true },
            { display: 'Kode Upline', name: 'upline_network_code', width: 90, sortable: true, align: 'center' },
            { display: 'Nama Upline', name: 'upline_member_name', width: 150, sortable: true, align: 'left', hide: true },
            { display: 'No. Telp', name: 'member_phone', width: 100, sortable: true, align: 'center', hide: true },
            { display: 'No. Handphone', name: 'member_mobilephone', width: 100, sortable: true, align: 'center', hide: true },
            { display: 'Tanggal Gabung', name: 'member_join_datetime', width: 180, sortable: true, align: 'center' },
            { display: 'Login Terakhir', name: 'member_last_login', width: 180, sortable: true, align: 'center', hide: true },
            { display: 'Kota / Kabupaten', name: 'member_city_name', width: 120, sortable: true, align: 'left', hide: true },
            { display: 'Propinsi', name: 'member_province_name', width: 120, sortable: true, align: 'left', hide: true },
            { display: 'Regional', name: 'member_region_name', width: 120, sortable: true, align: 'left', hide: true },
            { display: 'Negara', name: 'member_country_name', width: 150, sortable: true, align: 'left', hide: true },
            { display: 'Bank', name: 'member_bank_name', width: 120, sortable: true, align: 'left', hide: true },
            { display: 'Nama Nasabah', name: 'member_bank_account_name', width: 150, sortable: true, align: 'left', hide: true },
            { display: 'No. Rekening', name: 'member_bank_account_no', width: 100, sortable: true, align: 'left', hide: true },
            { display: 'Jumlah Kiri', name: 'network_total_downline_left', width: 70, sortable: true, align: 'center', hide: true },
            { display: 'Jumlah Kanan', name: 'network_total_downline_right', width: 80, sortable: true, align: 'center', hide: true },
            { display: 'No. Serial', name: 'member_serial_id', width: 100, sortable: true, align: 'center' },
            { display: 'PIN', name: 'member_serial_pin', width: 80, sortable: true, align: 'center' },
            <?php if($serial_type_count > 1): ?>
            { display: 'Tipe', name: 'member_serial_type_label', width: 100, sortable: true, align: 'center', hide: true },
            <?php endif; ?>
            { display: 'Aktif', name: 'member_is_active', width: 40, sortable: true, align: 'center' },
            { display: 'Detail', name: 'detail', width: 50, sortable: false, align: 'center', datasource: false },
        ],
        searchitems: [
            { display: 'Kode Member', name: 'network_code', type: 'text', isdefault: true },
            { display: 'Nama Member', name: 'member_name', type: 'text' },
            { display: 'Nama Alias', name: 'member_nickname', type: 'text' },
            { display: 'Kode Sponsor', name: 'sponsor_network_code', type: 'text' },
            { display: 'Nama Sponsor', name: 'sponsor_member_name', type: 'text' },
            { display: 'Kode Upline', name: 'upline_network_code', type: 'text' },
            { display: 'Nama Upline', name: 'upline_member_name', type: 'text' },
            { display: 'Tanggal Gabung', name: 'member_join_datetime', type: 'date' },
            { display: 'Kota / Kabupaten', name: 'member_city_id', type: 'select', option: '<?php echo $city_grid_options; ?>' },
            { display: 'Propinsi', name: 'member_province_id', type: 'select', option: '<?php echo $province_grid_options; ?>' },
            { display: 'Regional', name: 'member_region_id', type: 'select', option: '<?php echo $region_grid_options; ?>' },
            { display: 'Negara', name: 'member_country_id', type: 'select', option: '<?php echo $country_grid_options; ?>' },
            { display: 'No. Serial', name: 'member_serial_id', type: 'text' },
            { display: 'PIN', name: 'member_serial_pin', type: 'text' },
            <?php if($serial_type_count > 1): ?>
            { display: 'Tipe', name: 'member_serial_type_id', type: 'select', option: '<?php echo $serial_type_grid_options; ?>' },
            <?php endif; ?>
            { display: 'Status Aktif', name: 'member_is_active', type: 'select', option: '1:Aktif|0:Tidak Aktif' },
        ],
        sortname: "network_id",
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