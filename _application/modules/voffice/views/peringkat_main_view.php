<br>
<br>
<style>
    #tabel-peringkat th,#tabel-peringkat td {
        border-color:#ccc;
    }

    #tabel-peringkat {
        border-color: #ccc;
    }

</style>

<?php
if (!empty($peringkat)) {

    echo'<table class="table table-bordered table-striped" id="tabel-peringkat"> 
    <colgroup> 
        <col class="col-xs-1"> 
        <col class="col-xs-2"> 
        <col class="col-xs-2"> 
        <col class="col-xs-1"> 
        <col class="col-xs-1"> 
        <col class="col-xs-1"> 
        <col class="col-xs-2"> 
        <col class="col-xs-1"> 
    </colgroup> 
    <thead> 
        <tr> 
            <th>Kode Member</th> 
            <th>Nama Member</th> 
            <th>Peringkat</th> 
            <th>Jumlah TL</th> 
            <th>Jumlah SL</th> 
            <th>Jumlah SPV</th> 
            <th><center>Jumlah MGR</center></th> 
            <th>Jumlah GM</th> 
            <th>Jumlah BD</th> 
        </tr> 
    </thead> 
    <tbody> 
        <tr>';


    foreach ($peringkat as $row) {

        //buat query lagi sys_profit_sharing_grade_log where profit_sharing_grade_log_line_network_id = network_id and profit_sharing_grade_log_network_id = sponsor_network_id

        $sql = "SELECT
                            COUNT(IF(profit_sharing_grade_log_grade_profit_sharing_grade_title_id = 1, profit_sharing_grade_log_grade_profit_sharing_grade_title_id, NULL)) AS sl,
                            COUNT(IF(profit_sharing_grade_log_grade_profit_sharing_grade_title_id = 2, profit_sharing_grade_log_grade_profit_sharing_grade_title_id, NULL)) AS tl,
                            COUNT(IF(profit_sharing_grade_log_grade_profit_sharing_grade_title_id = 3, profit_sharing_grade_log_grade_profit_sharing_grade_title_id, NULL)) AS spv,
                            COUNT(IF(profit_sharing_grade_log_grade_profit_sharing_grade_title_id = 4, profit_sharing_grade_log_grade_profit_sharing_grade_title_id, NULL)) AS mgr,
                            COUNT(IF(profit_sharing_grade_log_grade_profit_sharing_grade_title_id = 5, profit_sharing_grade_log_grade_profit_sharing_grade_title_id, NULL)) AS gm,
                            COUNT(IF(profit_sharing_grade_log_grade_profit_sharing_grade_title_id = 6, profit_sharing_grade_log_grade_profit_sharing_grade_title_id, NULL)) AS bd
                            FROM sys_profit_sharing_grade_log
                            WHERE profit_sharing_grade_log_line_network_id = '" . $row->network_id . "' AND profit_sharing_grade_log_network_id = '" . $this->session->userdata('network_id') . "'
                            ";
        $query = $this->db->query($sql);
        $data = $query->result();

        //print_r($sql);

        foreach ($data as $row_count) {
            ?>
            <th><?php echo $row->network_code; ?></th>
            <th><?php echo $row->member_name; ?></th> 
            <th><?php echo $row->profit_sharing_grade_title_name; ?></th> 
            <th style="text-align:center"><?php echo $row_count->sl; ?></th> 
            <th style="text-align:center"><?php echo $row_count->tl; ?></th> 
            <th style="text-align:center"><?php echo $row_count->spv; ?></th> 
            <th style="text-align:center"><?php echo $row_count->mgr; ?></th> 
            <th style="text-align:center"><?php echo $row_count->gm; ?></th> 
            <th style="text-align:center"><?php echo $row_count->bd; ?></th> 
            </tr>      
            <?php
        }
    }
} else {
    echo '<div class="alert alert-success" role="alert">Anda Belum memiliki Downline</div>';
}
?>
</tbody> 
</table>