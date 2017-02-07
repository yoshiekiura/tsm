<?php
if(!empty($query)){
    foreach ($query as $row){
        echo '<li>
                <a href="' . base_url() . $row->menu_link . '">' . $row->menu_title . '</a>
            </li>';
    }
}
?>