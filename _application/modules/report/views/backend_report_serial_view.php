<h2>Laporan Data Serial</h2>
<table id="gridview" style="display:none;"></table>

<script>
    $("#gridview").flexigrid({
        url: 'get_serial_data',
        dataType: 'json',
        colModel: [
            { display: 'No. Serial', name: 'serial_id', width: 100, sortable: true, align: 'center' },
            //{ display: 'PIN', name: 'serial_pin', width: 80, sortable: true, align: 'center' },
            <?php if($this->sys_configuration['auto_network_code'] == 0): ?>
            { display: 'Kode Member', name: 'serial_network_code', width: 90, sortable: true, align: 'center' },
            <?php endif; ?>
            <?php if($serial_type_count > 1): ?>
            { display: 'Tipe', name: 'serial_type_label', width: 100, sortable: true, align: 'center' },
            <?php endif; ?>
            { display: 'Aktif', name: 'serial_is_active', width: 40, sortable: true, align: 'center' },
            { display: 'Terjual', name: 'serial_is_sold', width: 50, sortable: true, align: 'center' },
            { display: 'Terpakai', name: 'serial_is_used', width: 60, sortable: true, align: 'center' },
            { display: 'Tanggal Aktivasi', name: 'serial_activation_datetime', width: 180, sortable: true, align: 'center' },
            { display: 'Tanggal Terjual', name: 'serial_buyer_datetime', width: 180, sortable: true, align: 'center' },
            { display: 'Tanggal Terpakai', name: 'serial_user_datetime', width: 180, sortable: true, align: 'center' },
            { display: 'Kode Pembeli', name: 'buyer_network_code', width: 100, sortable: true, align: 'center' },
            { display: 'Nama Pembeli', name: 'buyer_member_name', width: 150, sortable: true, align: 'left' },
            { display: 'Kode Pengguna', name: 'user_network_code', width: 100, sortable: true, align: 'center' },
            { display: 'Nama Pengguna', name: 'user_member_name', width: 150, sortable: true, align: 'left' },
        ],
        searchitems: [
            { display: 'No. Serial', name: 'serial_id', type: 'num', isdefault: true },
            //{ display: 'PIN', name: 'member_serial_pin', type: 'text' },
            <?php if($this->sys_configuration['auto_network_code'] == 0): ?>
            { display: 'Kode Member', name: 'serial_network_code', type: 'num' },
            <?php endif; ?>
            <?php if($serial_type_count > 1): ?>
            { display: 'Tipe', name: 'serial_type_id', type: 'select', option: '<?php echo $serial_type_grid_options; ?>' },
            <?php endif; ?>
            { display: 'Status Aktif', name: 'serial_is_active', type: 'select', option: '1:Ya|0:Tidak' },
            { display: 'Status Terjual', name: 'serial_is_sold', type: 'select', option: '1:Ya|0:Tidak' },
            { display: 'Status Terpakai', name: 'serial_is_used', type: 'select', option: '1:Ya|0:Tidak' },
            { display: 'Tanggal Aktivasi', name: 'serial_activation_datetime', type: 'date' },
            { display: 'Tanggal Terjual', name: 'serial_buyer_datetime', type: 'date' },
            { display: 'Tanggal Terpakai', name: 'serial_user_datetime', type: 'date' },
            { display: 'Kode Pembeli', name: 'buyer_network_code', type: 'text' },
            { display: 'Nama Pembeli', name: 'buyer_member_name', type: 'text' },
            { display: 'Kode Pengguna', name: 'user_network_code', type: 'text' },
            { display: 'Nama Pengguna', name: 'user_member_name', type: 'text' },
        ],
        sortname: "serial_id",
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
    
    $(document).ready(function() {
        setInterval(function() {
            $('#gridview').flexReload();
        }, 300000);
        $.ajaxSetup({ cache: false });
    });
</script>