<?php
$generate_menu = '';
if (!empty($rs_menu)) {
    $i = 1;
    foreach ($rs_menu as $row_menu) {
        $last_menu_class = ($i >= $count) ? ' menu_kiri_akhir' : '';
        $generate_menu .= '<div class="menu_kiri' . $last_menu_class . '"><a href="' . base_url() . $row_menu->menu_link . '">' . $row_menu->menu_title . '</a></div>';
        $i++;
    }
}

echo $generate_menu;
?>