<?php
if(!empty($query)){
    foreach ($query as $row_menu){
        echo '<li><a href="'.base_url().$row_menu->menu_link.'">'.$row_menu->menu_title.' <i class="icon-chevron-right"></i></a></li>';
    }
}
?>