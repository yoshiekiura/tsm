<!-- About Us -->
<h4 class="title">Tentang Kami</h4>
<div class="footer-menu">
    <ul>
<?php
$id_parent = 7;
if (array_key_exists($id_parent, $arr_menu)) {

    // urutkan root menu berdasarkan menu_order_by
    ksort($arr_menu[$id_parent]);

    // ekstrak root menu
    foreach ($arr_menu[$id_parent] as $menu_sort => $menu_value) {

        if ($menu_value->menu_link == '#') {
            $menu_link = '#';
        } else {
            $menu_link = base_url() . $menu_value->menu_link;
        }
        echo '<li>
                <a title="' . $menu_value->menu_title . '" href="' . $menu_link . '">
                   ' . $menu_value->menu_title . '
                </a>
            </li>';
    }

}
?>
    </ul>
</div>
<!-- End About Us -->