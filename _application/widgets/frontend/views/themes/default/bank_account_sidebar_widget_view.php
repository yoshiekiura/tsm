<?php
$generate_bank_account = '';
if (!empty($rs_bank_account)) {
    $i = 1;
    foreach ($rs_bank_account as $row_bank_account) {
        $last_menu_class = ($i >= $count) ? ' menu_kiri_akhir' : '';
        
        $image_src = $row_bank_account->bank_logo;
        if ($image_src != '' && file_exists(_doc_root . _dir_bank . $image_src)) {
            $image = '<img src="' . base_url() . 'media/' . _dir_bank . '200/75/' . $image_src . '" alt="' . $row_bank_account->bank_name . '" title="' . $row_bank_account->bank_name . '" />';
        } else {
            $image = '<br /><h3 style="padding:0; margin:0;">' . strtoupper($row_bank_account->bank_name) . '</h3>';
        }
        $generate_bank_account .= '<div class="menu_kiri' . $last_menu_class . '" style="text-align:center; padding:0 0 15px 0;">' . $image . '<br />' . $row_bank_account->bank_account_no . '<br />a/n ' . strtoupper($row_bank_account->bank_account_name) . '</div>';
        $i++;
    }
}

echo $generate_bank_account;
?>