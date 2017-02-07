<h2>Bonus Member</h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>

<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->service_module_url; ?>/get_data',
        dataType: 'json',
        colModel: [
            { display: 'Kode Member', name: 'network_code', width: 90, sortable: true, align: 'center' },
            { display: 'Nama Member', name: 'member_name', width: 150, sortable: true, align: 'left' },
            { display: 'Nama Alias', name: 'member_nickname', width: 100, sortable: true, align: 'left', hide: true },
            { display: 'No. Telp', name: 'member_phone', width: 100, sortable: true, align: 'center', hide: true },
            { display: 'No. Handphone', name: 'member_mobilephone', width: 100, sortable: true, align: 'center', hide: true },
            { display: 'Bank', name: 'bank_name', width: 120, sortable: true, align: 'left', hide: true },
            { display: 'Nama Nasabah', name: 'member_bank_account_name', width: 150, sortable: true, align: 'left', hide: true },
            { display: 'No. Rekening', name: 'member_bank_account_no', width: 100, sortable: true, align: 'left', hide: true },
            { display: 'Aktif', name: 'member_is_active', width: 40, sortable: true, align: 'center', hide: true },
            <?php
            foreach($arr_active_bonus as $bonus_item) {
            ?>
            { display: '<?php echo $bonus_item['label']; ?> Diperoleh (Rp)', name: 'bonus_<?php echo $bonus_item['name']; ?>_in', width: <?php echo floor(strlen($bonus_item['label']) * 14); ?>, sortable: true, align: 'right', hide: true },
            { display: '<?php echo $bonus_item['label']; ?> Terbayar (Rp)', name: 'bonus_<?php echo $bonus_item['name']; ?>_out', width: <?php echo floor(strlen($bonus_item['label']) * 14); ?>, sortable: true, align: 'right', hide: true },
            { display: 'Saldo <?php echo $bonus_item['label']; ?> (Rp)', name: 'bonus_<?php echo $bonus_item['name']; ?>_saldo', width: <?php echo floor(strlen($bonus_item['label']) * 12.5); ?>, sortable: true, align: 'right' },
            <?php
            }
            ?>
            { display: 'Subtotal Diperoleh (Rp)', name: 'bonus_total_in', width: 145, sortable: true, align: 'right', hide: true },
            { display: 'Subtotal Terbayar (Rp)', name: 'bonus_total_out', width: 140, sortable: true, align: 'right', hide: true },
            { display: 'Subtotal Saldo (Rp)', name: 'bonus_total_saldo', width: 130, sortable: true, align: 'right' },
        ],
        buttons_right: [
            { display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '<?php echo $this->service_module_url; ?>/export_data' },
        ],
        searchitems: [
            { display: 'Kode Member', name: 'network_code', type: 'text', isdefault: true },
            { display: 'Nama Member', name: 'member_name', type: 'text' },
            { display: 'Nama Alias', name: 'member_nickname', type: 'text' },
            { display: 'Bank', name: 'bank_id', type: 'select', option: '<?php echo $bank_grid_options; ?>' },
            { display: 'Status Aktif', name: 'member_is_active', type: 'select', option: '1:Aktif|0:Tidak Aktif' },
        ],
        sortname: "network_id",
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