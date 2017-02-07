<?php
if ($query->num_rows() > 0) {
    $row = $query->row();
    if($row->page_dashboard_title != '') {
        echo '<h2>' . $row->page_dashboard_title . '</h2>';
    }
    echo '<br />';
    echo $row->page_dashboard_content;
} else {
    echo '<div class="error alert alert-danger"><p>Maaf, belum ada informasi terbaru untuk ditampilkan.</p></div>';
}
?>