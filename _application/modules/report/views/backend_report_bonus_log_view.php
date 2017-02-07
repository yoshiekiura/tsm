<h2>Laporan History Bonus</h2>
<table id="gridview" style="display:none;"></table>

<script>
    $("#gridview").flexigrid({
        url: 'get_bonus_log_data',
        dataType: 'json',
        colModel: [
            { display: 'Tanggal', name: 'bonus_log_date', width: 150, sortable: true, align: 'center' },
            <?php
            foreach($arr_active_bonus as $bonus_item) {
            ?>
            { display: '<?php echo $bonus_item['label']; ?> (Rp)', name: '<?php echo 'bonus_log_' . $bonus_item['name']; ?>_in', width: <?php echo floor(strlen($bonus_item['label']) * 10); ?>, sortable: true, align: 'right' },
            { display: '<?php echo $bonus_item['label']; ?> Terbayar (Rp)', name: '<?php echo 'bonus_log_' . $bonus_item['name']; ?>_out', width: <?php echo floor(strlen($bonus_item['label']) * 14.5); ?>, sortable: true, align: 'right', hide: true },
            { display: '<?php echo $bonus_item['label']; ?> Blm Terbayar (Rp)', name: '<?php echo 'bonus_log_' . $bonus_item['name']; ?>_saldo', width: <?php echo floor(strlen($bonus_item['label']) * 16.5); ?>, sortable: true, align: 'right', hide: true },
            <?php
            }
            ?>
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
    
    $(document).ready(function() {
        setInterval(function() {
            $('#gridview').flexReload();
        }, 300000);
        $.ajaxSetup({ cache: false });
    });
</script>