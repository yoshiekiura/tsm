<?php
if ($query->num_rows() > 0) {
    echo "<h5>
    No Rekening Perusahaan : 
</h5>";
    foreach ($query->result() as $row_bank) {
        ?>

        <table class="table table-condensed">
            <?php
            echo
            'Nama Bank : '.$row_bank->bank_name . 
            '<br> No Rekening : ' . $row_bank->bank_account_no .
            "<br> a / n : " . $row_bank->bank_account_name
            ?>
        </table>
        <?php
    }
}
?>