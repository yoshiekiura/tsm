<?php
if($query->num_rows() > 0) {
    $row = $query->row();
    
    echo $row->page_content;
}
?>