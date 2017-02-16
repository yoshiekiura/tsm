<style>
    .required {
        color:#dd0000;
        font-family:verdana;
        font-size:11pt;
    }
    .text_success {
        font-style:italic;
        color:#008800;
    }
    .text_error {
        font-style:italic;
        color:#dd0000;
    }
</style>


<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>

<div class="modal fade" id="confirmPin">
    <div class="modal-dialog modal-sm modal-info">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Konfirmasi PIN Serial
                </h4>
            </div>
            <form action="" method="post" id="formValidate">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="validate_pin" class="control-label">PIN Serial</label>
                        <input type="text" name="pin" id="pin" class="form-control"><span id="pin_status"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="validate_pin" class="btn btn-primary">Validasi PIN</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->module_url; ?>/get_data',
        dataType: 'json',
        colModel: [
            { display: 'Isi Testimoni', name: 'testimony_content', width: 500, sortable: true, align: 'left' },
            { display: 'Tanggal', name: 'testimony_datetime', width: 160, sortable: true, align: 'center' },
            { display: 'Ubah', name: 'edit', width: 40, sortable: false, align: 'center', datasource: false },
        ],
        buttons: [
            { display: 'Kirim Testimoni', name: 'add', bclass: 'add', onpress: redirect, urlaction: '<?php echo $this->module_url; ?>/add' },
            { separator: true },
            { display: 'Hapus', name: 'delete', bclass: 'delete', onpress: act_delete },
        ],
        searchitems: [
            { display: 'Tanggal', name: 'testimony_datetime', type: 'date', isdefault: true },
            { display: 'Status Aktif', name: 'testimony_is_active', type: 'select', option: '1:Aktif|0:Tidak Aktif' },
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

    function act_delete(com, grid) {
        var grid_id = $(grid).attr('id');
        grid_id = grid_id.substring(grid_id.lastIndexOf('grid_') + 5);
        if($('.trSelected', grid).length <= 0) {
            alert('Data Testimoni belum anda pilih.');
            return false;
        }else {
            $("#confirmPin").modal('show');
            $("#validate_pin").on('click',function(){
                var pin = $("#pin").val();
                    
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url();?>voffice/testimony/pin_validation',
                    data: 'pin='+pin,
                    dataType: 'json',
                    async: false,
                    success: function(pin_status) {
                        if(pin_status.length > 0){
                            var conf = confirm('Anda Akan Menghapus' + ' ' + $('.trSelected', grid).length + ' data Testimoni?');
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
                                    url: '<?php echo base_url();?>voffice/testimony/act_show',
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
                        }else{
                            var result_add_class = 'text_error';
                            var result_remove_class = 'text_success';
                            var result_text = 'Pin Tidak Valid';
                            $("#confirmPin").modal('show');
                            $("#pin_status").html(result_text).removeClass(result_remove_class).addClass(result_add_class);
                        }

                    }
                });
            });
        }
    }
</script>