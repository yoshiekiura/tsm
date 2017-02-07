<h2>Log Transfer Bonus</h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>

<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->service_module_url; ?>/get_data',
        dataType: 'json',
        colModel: [
            { display: 'Tanggal', name: 'bonus_transfer_datetime', width: 160, sortable: true, align: 'center' },
            { display: 'Kategori', name: 'bonus_transfer_category_text', width: 90, sortable: true, align: 'center' },
            { display: 'Tipe', name: 'bonus_transfer_type_text', width: 80, sortable: true, align: 'center' },
            { display: 'Total Data', name: 'count_bonus_transfer', width: 80, sortable: true, align: 'right' },
            { display: 'Pending', name: 'count_bonus_transfer_pending', width: 70, sortable: true, align: 'right' },
            { display: 'Gagal', name: 'count_bonus_transfer_failed', width: 50, sortable: true, align: 'right' },
            { display: 'Sukses', name: 'count_bonus_transfer_success', width: 60, sortable: true, align: 'right' },
            { display: 'Total Bonus', name: 'total_bonus_transfer_total_bonus', width: 130, sortable: true, align: 'right' },
            { display: 'Biaya Transfer', name: 'total_bonus_transfer_adm_charge', width: 140, sortable: true, align: 'right' },
            { display: 'Total Transfer', name: 'total_bonus_transfer_nett', width: 130, sortable: true, align: 'right' },
            { display: 'Download', name: 'detail', width: 65, sortable: false, align: 'center', datasource: false },
            { display: 'Download Pending', name: 'pending', width: 120, sortable: false, align: 'center', datasource: false },
        ],
        buttons_right: [
            { display: 'Export Excel', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '<?php echo $this->service_module_url; ?>/export_transfer_list' },
        ],
        searchitems: [
            { display: 'Tanggal', name: 'bonus_transfer_datetime', type: 'date', isdefault: true },
            { display: 'Kategori', name: 'bonus_transfer_category', type: 'select', option: 'daily:Harian|weekly:Mingguan|monthly:Bulanan|annual:Tahunan' },
            { display: 'Tipe', name: 'bonus_transfer_type', type: 'select', option: 'cash:Tunai|noncash:Non Tunai' },
        ],
        sortname: "bonus_transfer_id",
        sortorder: "desc",
        usepager: true,
        title: '',
        useRp: false,
        rp: 10,
        showTableToggleBtn: false,
        showToggleBtn: true,
        width: 'auto',
        height: '250',
        resizable: false,
        singleSelect: true
    });
</script>