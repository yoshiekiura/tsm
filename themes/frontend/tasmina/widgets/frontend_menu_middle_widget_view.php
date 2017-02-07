<!-- Middle Menu -->
<div id="widget_intro">
    <div class="container">
        <ul>
<?php
if (array_key_exists('0', $arr_menu)) {

    // urutkan root menu berdasarkan menu_order_by
    ksort($arr_menu[0]);

    // ekstrak root menu
    foreach ($arr_menu[0] as $menu_sort => $menu_value) {

        if ($menu_value->menu_link == '#') {
            $menu_link = '#';
        } else {
            $menu_link = base_url() . $menu_value->menu_link;
        }
        $first_word = strtok($menu_value->menu_title, ' ');
        $first_word_else = substr($menu_value->menu_title, strpos($menu_value->menu_title, ' '));
        echo '<li>
                <a class="img-effect" title="' . $menu_value->menu_title . '" href="#">
                    <span>' . $first_word . '</span>' . $first_word_else . '
                </a>
            </li>';
    }

}
?>
        </ul>
    </div>
</div>
<!-- End Middle Menu -->