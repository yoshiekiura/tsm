<h2><?php echo $title ?></h2>
<?php if ($otp_active): ?>
    <div id="response_message" style="display:none;"></div>
    <table id="gridview" style="display:none;"></table>
    <script>
        $("#gridview").flexigrid({
            url: '<?php echo $get_data_url; ?>',
            dataType: 'json',
            colModel: [
                { display: 'No.', name: 'no', width: 50, sortable: false, align: 'center' },
                { display: 'Nama User', name: 'user_name', width: 180, sortable: true, align: 'left' },
                { display: 'Kode OTP', name: 'code', width: 80, sortable: false, align: 'center' },
                { display: 'Tanggal Aktif', name: 'start_datetime', width: 180, sortable: true, align: 'center' },
                { display: 'Tanggal Expired', name: 'expired_datetime', width: 180, sortable: true, align: 'center', datasource: false },
            ],
            searchitems: [
                { display: 'Nama User', name: 'user_name', type: 'text', isdefault: true },
                { display: 'Tanggal Aktif', name: 'start_datetime', type: 'date' },
            ],
            sortname: "id",
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
<?php else: ?>
    <div class="alert alert-danger">Konfigurasi OTP tidak diaktifkan.</div>
<?php endif ?>