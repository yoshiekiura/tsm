<?php
error_reporting(1);
?>

<h2>Cek Data</h2>
<div class="box">
    <div class="box-title">
        <div class="caption"><i class="icon-reorder"></i>Form Cek Data</div>
    </div>
    <div class="box-body form">

        <form method="POST" action="" > 
            <div class="form-body">
                <div class="form-group">
                    <label class="control-label col-md-2">Input ID Member</label>
                    <div class="col-md-10">
                        <div class="input-group" id="defaultrange">
                            <input name="member" size="40" class="form-control" type="text">
                        </div>
                    </div>
                </div>
                <br>
            </div>
            <div class="form-actions fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-offset-2 col-md-10">
                            <button name="insert" type="submit" class="btn btn-success"><i class="icon-ok"></i> Cek Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>



<?php
if ($_POST['member'] != '') {
    $network_code = $_POST['member'];
    $network_id = $this->function_lib->get_one('sys_network', 'network_id', 'network_code =' . "'$network_code'");

    if (empty($network_id)) {
        echo "Data Member tidak ada";
    } else {

        $sponsor_network_id = $this->function_lib->get_one('sys_network', 'network_sponsor_network_id', 'network_id =' . $network_id);
        $sponsor_network_code = $this->function_lib->get_one('sys_network', 'network_code', 'network_id =' . $sponsor_network_id);
        $upline_network_id = $this->function_lib->get_one('sys_network', 'network_upline_network_id', 'network_id =' . $network_id);
        $upline_network_code = $this->function_lib->get_one('sys_network', 'network_code', 'network_id =' . $upline_network_id);




        echo "Data Member  : " . $network_code;
        echo "<br>";
        echo "Data Sponsor : " . $sponsor_network_code;
        echo "<br>";
        echo "Data Upline  : " . $upline_network_code;
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo " 
         <table class='items' border='2' ; >
            <tr>
                <th width='200' style='font-size:15px'>
                    Bonus Sponsor
                </th>
                <th width='300' style='font-size:15px'>
                   Bonus Gen Sponsor
                </th>
                <th width='300' style='font-size:15px'>
                    Bonus Profit Sharing
                </th>
                <th width='300' style='font-size:15px'>
                    Bonus Royalti Payment
                </th>
                

            </tr>";

        $sql = "SELECT * FROM sys_bonus where bonus_network_id = " . $network_id . "";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $bonus_sponsor = $row->bonus_sponsor_acc - $row->bonus_sponsor_paid;
                $bonus_gen_sponsor = $row->bonus_gen_sponsor_acc - $row->bonus_gen_sponsor_paid;
                $bonus_profit_sharing = $row->bonus_profit_sharing_acc - $row->bonus_profit_sharing_paid;
                $bonus_royalti_payment = $row->bonus_royalty_payment_acc - $row->bonus_royalty_payment_paid;

                echo "<tr>";
                echo '<td align="center" style="padding-top:10px;font-size:20px">' . number_format($bonus_sponsor) . '</td>';
                echo '<td align="center" style="padding-top:10px;font-size:20px">' . number_format($bonus_gen_sponsor) . '</td>';
                echo '<td align="center" style="padding-top:10px;font-size:20px">' . number_format($bonus_profit_sharing) . '</td>';
                echo '<td align="center" style="padding-top:10px;font-size:20px">' . number_format($bonus_royalti_payment) . '</td>';

                echo "</tr>";
            }
            echo "</table>";
        }
    }
} else {
    echo "";
}
?>