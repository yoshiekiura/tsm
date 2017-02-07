<h2>Data Anggota Grup</h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>
<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->module_url; ?>/get_network_group_data',
        dataType: 'json',
        colModel: [
            { display: 'Kode Member', name: 'network_code', width: 120, sortable: true, align: 'center' },
            { display: 'Nama Member', name: 'member_name', width: 250, sortable: true, align: 'left' },
            { display: 'Nama Alias', name: 'member_nickname', width: 150, sortable: true, align: 'left', hide: true },
            { display: 'Tanggal', name: 'network_group_input_datetime', width: 180, sortable: true, align: 'center' },
            { display: 'Konfirmasi', name: 'network_group_is_approve', width: 80, sortable: true, align: 'center' },
        ],
        buttons: [
            { display: 'Tambah Anggota', name: 'add', bclass: 'add', onpress: redirect, urlaction: '<?php echo $this->module_url; ?>/network_group_add' },
            { separator: true },
            { display: 'Keluarkan Dari Grup', name: 'delete', bclass: 'delete', onpress: act_show_member },
        ],
        searchitems: [
            { display: 'Kode Member', name: 'network_group_member_network_code', type: 'date', isdefault: true },
            { display: 'Nama Member', name: 'downline_member_name', type: 'text' },
            { display: 'Nama Alias', name: 'downline_member_nickname', type: 'text' },
            { display: 'Tanggal', name: 'network_group_input_datetime', type: 'date' },
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
    
    function act_show_member(com, grid) {
        var grid_id = $(grid).attr('id');
        grid_id = grid_id.substring(grid_id.lastIndexOf('grid_') + 5);

        if($('.trSelected', grid).length > 0) {
            var conf = confirm('Keluarkan ' + $('.trSelected', grid).length + ' anggota dari grup?');
            if(conf == true) {
                var arr_id = [];
                var i = 0;
                $('.trSelected', grid).each(function() {
                    var id = $(this).attr('data-id');
                    arr_id.push(id);
                    i++;
                });
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->module_url; ?>/act_network_group_show',
                    data: com + '=true&item=' + JSON.stringify(arr_id),
                    dataType: 'json',
                    success: function(response) {
                        $('#' + grid_id).flexReload();
                        if(response['message'] != '') {
                            if(response['success'] == '1') {
                                window.location.href = '<?php echo base_url() . uri_string(); ?>';
                            } else {
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
                    }
                });
            }
        }
    }
</script>