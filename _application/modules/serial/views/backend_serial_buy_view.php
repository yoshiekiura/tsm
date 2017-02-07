<h3>Penjualan Serial</h3>
<div id="response_message" style="display:none;"></div>

<table class="table table-striped table-hover" style="margin:0;">
    <thead>
        <tr style="background-color:#dfddfd;">
            <th colspan="3"><h4 style="padding:0; margin:0;">Data Pembeli</h4></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th width="120"><h5 style="padding:0; margin:0;">Kode Member</h5></th>
            <th width="1"><h5 style="padding:0; margin:0;">:</h5></th>
            <td><h5 style="padding:0; margin:0;"><input type="hidden" id="network_id" value="" /><span id="network_code">-</span></h5></td>
        </tr>
        <tr>
            <th><h5 style="padding:0; margin:0;">Nama</h5></th>
            <th><h5 style="padding:0; margin:0;">:</h5></th>
            <td><h5 style="padding:0; margin:0;"><span id="member_name">-</span></h5></td>
        </tr>
    </tbody>
</table>
<table id="gridview" style="display:none;"></table>

<div id="dialog_member" title="Silakan Pilih Member Pembeli">
    <table id="gridview_member" style="display:none;"></table>
</div>

<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->service_module_url; ?>/get_data/buy',
        dataType: 'json',
        colModel: [
            { display: 'No. Serial', name: 'serial_id', width: 150, sortable: true, align: 'center' },
            <?php if($this->sys_configuration['auto_network_code'] == 0): ?>
            { display: 'Kode Member', name: 'serial_network_code', width: 150, sortable: true, align: 'center' },
            <?php endif; ?>
            <?php if($serial_type_count > 1): ?>
            { display: 'Tipe', name: 'serial_type_label', width: 140, sortable: true, align: 'center' },
            <?php endif; ?>
            { display: 'Aktif', name: 'serial_is_active', width: 40, sortable: true, align: 'center' },
            { display: 'Terjual', name: 'serial_is_sold', width: 50, sortable: true, align: 'center' },
            { display: 'Terpakai', name: 'serial_is_used', width: 60, sortable: true, align: 'center' },
        ],
        buttons: [
            { display: 'Pilih Pembeli', name: 'member', bclass: 'user', onpress: show_member },
            { separator: true },
            { display: 'Pilih Semua', name: 'selectall', bclass: 'selectall', onpress: check },
            { separator: true },
            { display: 'Batalkan Pilihan', name: 'selectnone', bclass: 'selectnone', onpress: check },
        ],
        buttons_right: [
            { display: 'Simpan Penjualan Serial', name: 'save', bclass: 'accept', onpress: save },
        ],
        searchitems: [
            { display: 'No. Serial', name: 'serial_id', type: 'num', isdefault: true },
            <?php if($this->sys_configuration['auto_network_code'] == 0): ?>
            { display: 'Kode Member', name: 'serial_network_code', type: 'num' },
            <?php endif; ?>
            <?php if($serial_type_count > 1): ?>
            { display: 'Tipe', name: 'serial_type_id', type: 'select', option: '<?php echo $serial_type_grid_options; ?>' },
            <?php endif; ?>
        ],
        sortname: "serial_id",
        sortorder: "asc",
        usepager: true,
        title: '',
        useRp: true,
        rp: 100,
        showTableToggleBtn: false,
        showToggleBtn: true,
        width: 'auto',
        height: '270',
        resizable: false,
        singleSelect: false
    });
    
    /* member starts here */
    function show_member() {
        $("#gridview_member tbody tr").removeClass('trSelected');
        $("#gridview_member").flexReload();
        $("#dialog_member").dialog("open");
    }
    
    $("#dialog_member").dialog({ 
        autoOpen: false,
        modal: true,
        width: '80%'
    });
    
    $("#gridview_member").flexigrid({
        url: '<?php echo $this->service_module_url; ?>/get_member',
        dataType: 'json',
        colModel: [
            { display: 'Kode Member', name: 'network_code', width: 90, sortable: true, align: 'center' },
            { display: 'Nama Member', name: 'member_name', width: 150, sortable: true, align: 'left' },
            { display: 'No. Telp', name: 'member_phone', width: 100, sortable: true, align: 'center' },
            { display: 'No. Handphone', name: 'member_mobilephone', width: 100, sortable: true, align: 'center' },
            { display: 'Kota / Kabupaten', name: 'member_city_name', width: 120, sortable: true, align: 'left' },
            { display: 'Propinsi', name: 'member_province_name', width: 120, sortable: true, align: 'left' },
            { display: 'Regional', name: 'member_region_name', width: 120, sortable: true, align: 'left', hide: true },
            { display: 'Negara', name: 'member_country_name', width: 150, sortable: true, align: 'left', hide: true },
            { display: 'Aktif', name: 'member_is_active', width: 40, sortable: true, align: 'center' },
        ],
        buttons: [
            { display: 'Pilih', name: 'change', bclass: 'accept', onpress: select_member },
            { separator: true }
        ],
        searchitems: [
            { display: 'Kode Member', name: 'network_code', type: 'text', isdefault: true },
            { display: 'Nama Member', name: 'member_name', type: 'text' },
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
        singleSelect: true
    });

    function select_member(com, grid) {
        if($('.trSelected', grid).length > 0) {
            $('.trSelected', grid).each(function() {
                var network_id = $(this).attr('data-id');
                var network_code = $('td[abbr="network_code"] > div > span', this).html();
                var member_name = $('td[abbr="member_name"] > div > span', this).html();
                $("#network_id").val(network_id);
                $("#network_code").html(network_code);
                $("#member_name").html(member_name);
                $("#dialog_member").dialog("close");
            });
        } else {
            alert("Data belum anda pilih");
            return false;
        }
    }
    /* member ends here */
    
    function save(com, grid) {
        var grid_id = $(grid).attr('id');
        grid_id = grid_id.substring(grid_id.lastIndexOf('grid_') + 5);

        var network_id = $("#network_id").val();
        if(network_id.length <= 0) {
            alert('Data Pembeli belum anda pilih.');
            return false;
        } else if($('.trSelected', grid).length <= 0) {
            alert('Data Serial belum anda pilih.');
            return false;
        } else {
            if(confirm('Simpan Penjualan Serial?') == true) {
                var arr_id = [];
                var i = 0;
                $('.trSelected', grid).each(function() {
                    var id = $(this).attr('data-id');
                    arr_id.push(id);
                    i++;
                });
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->service_module_url; ?>/act_buy',
                    data: com + '=true&network_id=' + JSON.stringify(network_id) + 
                            '&arr_item=' + JSON.stringify(arr_id),
                    dataType: 'json',
                    success: function(response) {
                        if(response['message'] != '') {
                            if(response['message_class'] != 'response_error') {
                                $("#network_id").val('');
                                $("#network_code").html('-');
                                $("#member_name").html('-');
                                $('#' + grid_id).flexReload();
                            }
                            var message_class = response['message_class'];
                            if(message_class == '') {
                                message_class = 'response_confirmation alert alert-success';
                            }
                            $("#response_message").addClass(message_class);
                            $("#response_message").slideDown("fast");
                            $("#response_message").html(response['message']);
                            $("#response_message").delay(5000).slideUp(1000, function() {
                                $("#response_message").removeClass(message_class);
                            });
                        }
                    }
                });
            }
        }
    }
</script>