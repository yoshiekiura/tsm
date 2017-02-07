<?php

$generate_menu = '';
$generate_menu = '<li><a href="' . base_url() . '">Beranda</a></li>';


if (array_key_exists('0', $arr_menu)) {

    // urutkan root menu berdasarkan menu_order_by
    ksort($arr_menu[0]);

    // ekstrak root menu
    foreach ($arr_menu[0] as $menu_sort => $menu_value) {

        if (array_key_exists($menu_value->menu_id, $arr_menu)) {
            $menu_link = '#';
            $menu_class = 'dropdown';
        } else {
            if ($menu_value->menu_link == '#') {
                $menu_link = '#';
            } else {
                $menu_link = base_url() . $menu_value->menu_link;
            }
            $menu_class = '';
        }
        $generate_menu .= '
                    <li class="' . $menu_class . '" title="' . $menu_value->menu_description . '">
                        <a href="' . $menu_link . '">
                            <span class="title">' . $menu_value->menu_title . '</span>
                            <span class="arrow"></span>
                        </a>
                ';

        // cari submenu 1
        if (array_key_exists($menu_value->menu_id, $arr_menu)) {
            $generate_menu .= '<ul class="sub-menu" >';
            // urutkan submenu 1 berdasarkan menu_order_by
            ksort($arr_menu[$menu_value->menu_id]);

            // ekstrak submenu 1 yang par_id adalah menu_id dari root menu
            foreach ($arr_menu[$menu_value->menu_id] as $submenu_1_sort => $submenu_1_value) {
                if ($submenu_1_value->menu_link == '#') {
                    $submenu_1_link = '#';
                } else {
                    $submenu_1_link = base_url() . $submenu_1_value->menu_link;
                }

                $generate_menu .= '<li title="' . $submenu_1_value->menu_description . '"><a href="' . $submenu_1_link . '">' . $submenu_1_value->menu_title . '</a></li>';
            }
            $generate_menu .= '</ul>';
        }
        $generate_menu .= '</li>';
    }

    $generate_menu .= '</ul>';
}

echo $generate_menu;