<!-- Footer Menu -->
<div class="footer-menu">
    <h4 class="title">Tautan Langsung</h4>
    <div class="row">
        <ul class="half-menu col-md-6">
<?php
if (array_key_exists('0', $arr_menu)) {

    // urutkan root menu berdasarkan menu_order_by
    ksort($arr_menu[0]);

    // ekstrak root menu
    $i=1;
    foreach ($arr_menu[0] as $menu_sort => $menu_value) {

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
        if ($i%5==0) {
            echo '</ul> <ul class="half-menu col-md-6">';
        }
        $i++;
    }

}
?>
        </ul>
    </div>
</div>
<!-- End Footer Menu -->