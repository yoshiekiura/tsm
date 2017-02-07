<h2>Rekapitulasi Bonus <?php echo $arr_transfer_config['title']; ?></h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>

<script>
    $("#gridview").flexigrid({
        url: '<?php echo $this->service_module_url; ?>/get_preview_data/<?php echo $category; ?>',
        dataType: 'json',
        colModel: [
            { display: 'Kode Member', name: 'network_code', width: 100, sortable: true, align: 'center' },
            { display: 'Nama Member', name: 'member_name', width: 150, sortable: true, align: 'left' },
            { display: 'Nama Alias', name: 'member_nickname', width: 100, sortable: true, align: 'left', hide: true },
            { display: 'No. Telp', name: 'member_phone', width: 100, sortable: true, align: 'center', hide: true },
            { display: 'No. Handphone', name: 'member_mobilephone', width: 100, sortable: true, align: 'center', hide: true },
            { display: 'Bank', name: 'member_bank_name', width: 120, sortable: true, align: 'left' },
            { display: 'Nama Nasabah', name: 'member_bank_account_name', width: 150, sortable: true, align: 'left', hide: true },
            { display: 'No. Rekening', name: 'member_bank_account_no', width: 100, sortable: true, align: 'left' },
            <?php
            foreach($arr_transfer_config['arr_bonus'] as $bonus_item) {
            ?>
            { display: '<?php echo $arr_all_bonus_config[$bonus_item]['label']; ?> (Rp)', name: 'bonus_<?php echo $bonus_item; ?>', width: <?php echo floor(strlen($arr_all_bonus_config[$bonus_item]['label']) * 10); ?>, sortable: true, align: 'right', hide: true },
            <?php
            }
            ?>
            { display: 'Total Bonus (Rp)', name: 'bonus_total', width: 120, sortable: true, align: 'right' },
            { display: 'Biaya Transfer (Rp)', name: 'adm_charge', width: 140, sortable: true, align: 'right' },
            { display: 'Total Transfer (Rp)', name: 'nett', width: 130, sortable: true, align: 'right' },
        ],
        buttons: [
            { display: 'Rekap Bonus', name: 'submit', bclass: 'accept', onpress: submit },
        ],
        buttons_right: [
            { display: 'Download Preview', name: 'excel', bclass: 'excel', onpress: export_data, urlaction: '<?php echo $this->service_module_url; ?>/export_preview_data/<?php echo $category; ?>' },
        ],
        searchitems: [
            { display: 'Kode Member', name: 'network_code', type: 'text', isdefault: true },
            { display: 'Nama Member', name: 'member_name', type: 'text' },
            { display: 'Nama Alias', name: 'member_nickname', type: 'text' },
            { display: 'No. Handphone', name: 'member_mobilephone', type: 'text' },
            { display: 'Bank', name: 'member_bank_id', type: 'select', option: '<?php echo $bank_grid_options; ?>' },
            { display: 'No. Rekening', name: 'member_bank_account_no', type: 'text' },
        ],
        sortname: "member_bank_name",
        sortorder: "asc",
        usepager: true,
        title: '',
        useRp: false,
        rp: 10000,
        showTableToggleBtn: false,
        showToggleBtn: true,
        width: 'auto',
        height: '250',
        resizable: false,
        singleSelect: true
    });
    
    function submit(com, grid) {
        var grid_id = $(grid).attr('id');
        grid_id = grid_id.substring(grid_id.lastIndexOf('grid_') + 5);
        
        var qselectused = false;
        var optionused = false;
        var selectedoption = '';
        var option = '';
        $(".sDiv .qselect", grid).each(function() {
            var id = $(this).attr('id');
            var show =  $("#" + id).is(':hidden');
            if(show == false) {
                qselectused = true;
                selectedoption = $("#" + id + " select[name=qoption] option:selected").val();
            }
        });

        if(qselectused == true) {
            option = selectedoption;
            optionused = true;
        } else {
            option = '';
            optionused = false;
        }
        var query = $(".sDiv input[name=q]", grid).val();
        var date_start = $(".sDiv input[name=qdatestart]", grid).val();
        var date_end = $('.sDiv input[name=qdateend]', grid).val();
        var qtype = $(".sDiv select[name=qtype]", grid).val();
        
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->service_module_url; ?>/act_add/<?php echo $category; ?>',
            data: com + '=true' + 
                '&query=' + query + 
                '&optionused=' + optionused + 
                '&option=' + option + 
                '&date_start=' + date_start + 
                '&date_end=' + date_end + 
                '&qtype=' + qtype,
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
                }
            }
        });
    }
</script>