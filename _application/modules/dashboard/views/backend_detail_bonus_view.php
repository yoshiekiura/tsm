<h2>Detail Bonus</h2>
<div id="response_message" style="display:none;"></div>
<table id="gridview" style="display:none;"></table>
<script>
    $("#gridview").flexigrid({
    url: '<?php echo $this->service_module_url; ?>/get_data_detail',
            dataType: 'json',
            colModel: [
            {display: 'Kode Member', name: 'network_code', width: 200, sortable: true, align: 'left'},
            {display: 'Bonus Sponsor', name: 'bonus_sponsor_acc', width: 180, sortable: true, align: 'center'},
            {display: 'Bonus Generasi Sponsor', name: 'bonus_gen_sponsor_acc', width: 180, sortable: true, align: 'center'},
            {display: 'Bonus Profit Sharing', name: 'bonus_profit_sharing_acc', width: 180, sortable: false, align: 'center', datasource: false},
            {display: 'Bonus Royalti Payment', name: 'bonus_royalty_payment_acc', width: 180, sortable: false, align: 'center', datasource: false},
            ],
//        searchitems: [
////            { display: 'Judul', name: 'news_title', type: 'text', isdefault: true },
////            { display: 'Tanggal Input', name: 'news_input_datetime', type: 'date' },
////            { display: 'Status Aktif', name: 'news_is_active', type: 'select', option: '1:Aktif|0:Tidak Aktif' },
//        ],
            sortname: "bonus_network_id",
            sortorder: "ASC",
            usepager: true,
            title: '',
            useRp: true,
            rp: 10,
            showTableToggleBtn: false,
            showToggleBtn: true,
            width: 'auto',
            height: '300',
            resizable: false,
            singleSelect: false

//            onSuccess: function(com, grid) {
//            act_summary(com, grid);
//            },
    });
            function act_summary(com, grid) {
            var qselectused = false;
                    var optionused = false;
                    var selectedoption = '';
                    var option = '';
                    $(".sDiv .qselect", grid).each(function() {
            var id = $(this).attr('id');
                    var show = $("#" + id).is(':hidden');
                    if (show == false) {
            qselectused = true;
                    selectedoption = $("#" + id + " select[name=qoption] option:selected").val();
            }
            });
                    if (qselectused == true) {
            option = selectedoption;
                    optionused = true;
            } else {
            option = '';
                    optionused = false;
            }
            var date_start = $(".sDiv input[name=qdatestart]", grid).val();
                    var date_end = $('.sDiv input[name=qdateend]', grid).val();
                    var qtype = $(".sDiv select[name=qtype]", grid).val();
                    var query = $(".sDiv input[name=q]", grid).val();
                    $.ajax({
                    type: 'POST',
                            url: 'get_summary_data',
                            data: 'date_start=' + date_start + '&date_end=' + date_end + '&qtype=' + qtype + '&query=' + query + '&option=' + option + '&optionused=' + optionused,
                            dataType: 'json',
                            success: function(response) {
                            $("#summary_table").closest('tr').remove();
                                    if (response['arr_data'] != '') {
                            var arr_data = response['arr_data'];
                                    var grandtotal = 0;
                                    var percentage_total = 0;
                                    $.each(arr_data, function (index, value) {
                                    grandtotal += parseInt(value.total_income_value);
                                    });
                                    var tr = '';
                                    tr += '<tr>';
                                    tr += '<td width="220"><strong>TOTAL SEMUA KLIEN</strong></td>';
                                    tr += '<td width="10"><strong>Rp.</strong></td>';
                                    tr += '<td width="120" align="right"><strong>' + format_money(grandtotal) + '</strong></td>';
                                    tr += '<td width="100" align="right"><strong>(<span id="percentage_total">0</span> %)</strong></td>';
                                    tr += '<td>&nbsp;</td>';
                                    tr += '</tr>';
                                    $.each(arr_data, function (index, value) {
                                    var percentage = parseFloat(value.total_income_value / grandtotal * 100);
                                            percentage_total += percentage;
                                            tr += '<tr>';
                                            tr += '<td width="220">' + value.client_name + '</td>';
                                            tr += '<td width="10">Rp.</td>';
                                            tr += '<td width="120" align="right">' + format_money(value.total_income_value) + '</td>';
                                            tr += '<td width="100" align="right">(' + format_decimal(percentage) + ' %)</td>';
                                            tr += '<td>&nbsp;</td>';
                                            tr += '</tr>';
                                    });
                                    $("#summary_table").html(tr);
                                    $("#percentage_total").html(format_decimal(percentage_total));
                            }
                            }
                    });
            }

</script>