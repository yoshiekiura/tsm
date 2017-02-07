<?php
$arr_menu = array();
$generate_menu = '';
$menu_id_active = 0;
if (!empty($rs_menu)) {
    foreach ($rs_menu as $row_menu) {
        $arr_menu[$row_menu->menu_par_id][$row_menu->menu_order_by] = $row_menu;
        
        if($row_menu->menu_link == $this->uri->uri_string()) {
            if($row_menu->menu_par_id == '0') {
                $menu_id_active = $row_menu->menu_id;
            } else {
                $menu_id_active = $row_menu->menu_par_id;
            }
        }
    }
}

// cari root menu
if (array_key_exists('0', $arr_menu)) {

    $generate_menu .= '<ul class="sf-menu">';
    $active = '';
    if ($this->uri->segment(1) == '') {
        $active = 'class="active"';
    }
    $generate_menu .= '<li><a href="' . base_url() . '" ' . $active . ' title="HOME">Home</a></li>';

    // urutkan root menu berdasarkan menu_order_by
    ksort($arr_menu[0]);

    // ekstrak root menu
    foreach ($arr_menu[0] as $rootmenu_sort => $rootmenu_value) {
        $menu_title = $rootmenu_value->menu_title;
        
        $active = '';
        if($rootmenu_value->menu_id == $menu_id_active) {
            $active = 'class="active"';
        }

        if (strpos($rootmenu_value->menu_link, 'http://') === false) {
            $menu_link = '<a href="' . base_url() . $rootmenu_value->menu_link . '" '.$active.' title="' . $menu_title . '">' . $menu_title . '</a>';
        } else {
            $menu_link = '<a href="' . $rootmenu_value->menu_link . '" '.$active.' title="' . $menu_title . '" target="_blank">' . $menu_title . '</a>';
        }

        $generate_menu .= '<li>' . $menu_link;

        // cari submenu 1
        if (array_key_exists($rootmenu_value->menu_id, $arr_menu)) {

            $generate_menu .= '<ul>';

            // urutkan submenu 1 berdasarkan menu_order_by
            ksort($arr_menu[$rootmenu_value->menu_id]);

            // ekstrak submenu 1 yang par_id adalah menu_id dari root menu
            foreach ($arr_menu[$rootmenu_value->menu_id] as $submenu_1_sort => $submenu_1_value) {
                
                $submenu_1_title = $submenu_1_value->menu_title;
                if (strpos($submenu_1_value->menu_link, 'http://') === false) {
                    $submenu_link = '<a href="' . base_url() . $submenu_1_value->menu_link . '" title="' . $submenu_1_title . '">' . $submenu_1_title . '</a>';
                } else {
                    $submenu_link = '<a href="' . $submenu_1_value->menu_link . '" title="' . $submenu_1_title . '" target="_blank">' . $submenu_1_title . '</a>';
                }

                $generate_menu .= '<li>' . $submenu_link . '</li>';
            }

            $generate_menu .= '</ul>';
        }

        $generate_menu .= '</li>';
    }
    $generate_menu .= '</ul>';
}

echo $generate_menu;
?>