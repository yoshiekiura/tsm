<h2>Approval Testimoni</h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>
<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->service_module_url; ?>/get_approve_data',
        dataType: 'json',
        colModel: [
            { display: 'Nama', name: 'member_name', width: 150, sortable: true, align: 'left' },
            { display: 'Isi Testimoni', name: 'testimony_content', width: 400, sortable: true, align: 'left' },
            { display: 'Tanggal', name: 'testimony_datetime', width: 160, sortable: true, align: 'center' },
        ],
        buttons: [
            { display: 'Pilih Semua', name: 'selectall', bclass: 'selectall', onpress: check },
            { separator: true },
            { display: 'Batalkan Pilihan', name: 'selectnone', bclass: 'selectnone', onpress: check },
            { separator: true },
            { display: 'Setujui', name: 'approve', bclass: 'accept', onpress: act_approve },
        ],
        searchitems: [
            { display: 'Nama', name: 'testimony_name', type: 'text', isdefault: true },
            { display: 'Tanggal', name: 'testimony_datetime', type: 'date' },
        ],
        sortname: "testimony_datetime",
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

    function act_approve(com, grid) {
        var grid_id = $(grid).attr('id');
        grid_id = grid_id.substring(grid_id.lastIndexOf('grid_') + 5);

        if($('.trSelected', grid).length > 0) {
            var title = '';
            if (com == 'approve') {
                title = 'Setujui';
            }

            var conf = confirm(title + ' ' + $('.trSelected', grid).length + ' data?');
            if(conf == true) {
                var arr_id = [];
                var i = 0;
                $('.trSelected', grid).each(function() {
                    var id = $(this).attr('id');
                    var arr_string_id = id.split('_');
                    id = arr_string_id[arr_string_id.length - 1];
                    arr_id.push(id);
                    i++;
                });
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->service_module_url; ?>/act_approve',
                    data: com + '=true&item=' + JSON.stringify(arr_id),
                    dataType: 'json',
                    success: function(response) {
                        $('#' + grid_id).flexReload();
                        if(response['message'] != '') {
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