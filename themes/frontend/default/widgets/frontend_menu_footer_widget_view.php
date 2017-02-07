<?php
if(!empty($query)){
    echo '<a href="' . base_url() . '">Beranda</a>';
    foreach ($query as $row){
        echo '<a href="' . base_url() . $row->menu_link . '">' . $row->menu_title . '</a>';
    }
}
?>