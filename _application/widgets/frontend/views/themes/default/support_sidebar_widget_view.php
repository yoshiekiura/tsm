<?php
$generate_support = '';
if (!empty($rs_support)) {
    $i = 1;
    foreach ($rs_support as $row_support) {
        $last_menu_class = ($i >= $count) ? ' menu_kiri_akhir' : '';
        $generate_support .= '<div class="menu_kiri' . $last_menu_class . '" style="padding:7px 0 7px 0;">';
        $generate_support .= '<table width="90%" cellpadding="2" cellspacing="0" border="0" align="center">';
        $generate_support .= '<tr valign="top">';
        $generate_support .= '<td align="left"><strong>' . $row_support->support_name . '</strong><br />' . $row_support->support_phone . '</td>';
        $generate_support .= '<td width="10%" style="text-align:right;">' . ymstatus($row_support->support_nick, base_url() . 'images/support/icon_yahoo_64x16_on.gif', base_url() . 'images/support/icon_yahoo_64x16_off.gif', 'Yahoo! Messenger') . '</td>';
        $generate_support .= '</tr>';
        $generate_support .= '</table>';
        $generate_support .= '</div>';
        $i++;
    }
}

echo $generate_support;
?>