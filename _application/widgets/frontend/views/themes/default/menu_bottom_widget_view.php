<?php
$arr_menu = array();
$generate_menu = '';
if (!empty($rs_menu)) {
    foreach ($rs_menu as $row_menu) {
        $arr_menu[$row_menu->menu_par_id][$row_menu->menu_order_by] = $row_menu;
    }
}

// cari root menu
if (array_key_exists('0', $arr_menu)) {

    $generate_menu .= '<ul>';
    $generate_menu .= '<li><a href="' . base_url() . '" title="Home">Home</a></li>';

    // urutkan root menu berdasarkan menu_order_by
    ksort($arr_menu[0]);

    // ekstrak root menu
    foreach ($arr_menu[0] as $rootmenu_sort => $rootmenu_value) {
        
        $generate_menu .= '<li><a href="' . base_url() . $rootmenu_value->menu_link . '" title="' . $rootmenu_value->menu_title . '">' . $rootmenu_value->menu_title . '</a>';

        // cari submenu 1
        if (array_key_exists($rootmenu_value->menu_id, $arr_menu)) {

            $generate_menu .= '<ul>';

            // urutkan submenu 1 berdasarkan menu_order_by
            ksort($arr_menu[$rootmenu_value->menu_id]);

            // ekstrak submenu 1 yang par_id adalah menu_id dari root menu
            foreach ($arr_menu[$rootmenu_value->menu_id] as $submenu_1_sort => $submenu_1_value) {
                
                $generate_menu .= '<li><a href="' . base_url() . $submenu_1_value->menu_link . '" title="' . $submenu_1_value->menu_title . '">' . $submenu_1_value->menu_title . '</a></li>';
            }

            $generate_menu .= '</ul>';
        }

        $generate_menu .= '</li>';
    }
    
    $generate_menu .= '</ul>';
}

echo $generate_menu;
?>