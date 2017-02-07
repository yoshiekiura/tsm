<div id="widget-mplan">
    <?php
    if (!empty($query)) {
        $i = 1;
        echo '<ul class="nav nav-tabs" role="tablist">';
        foreach ($query as $row) {
            if ($i == 1) {

                echo '<li class="active"><a href="#' . $row->page_mp_id . ' " role="tab" data-toggle="tab">' . $row->page_mp_title . '</a></li>';
            } else {

                echo '<li   ><a href="#' . $row->page_mp_id . ' " role="tab" data-toggle="tab">' . $row->page_mp_title . '</a></li>';
            }

            $i++;
        }
    } else {
        echo '<div class = "alert alert-danger" role = "alert">
                <span class = "glyphicon glyphicon-exclamation-sign" aria-hidden = "true"></span>
                <center><span class = "sr-only">Error:</span>
                Mohon Maaf, Marketing Plan Belum Tersedia</center>
                </div>';
    }
    ?>
</ul>

<!-- Tab panes -->
<?php
if (!empty($query)) {
    echo '<div class="tab-content">';
    $i = 1;
    foreach ($query as $data) {
        if ($i == 1) {
            echo'<div class="tab-pane fade in active" id="' . $data->page_mp_id . '">';
            echo'<div class = "row">';
            // echo'<div class = "col-md-12">';
            // if (!empty($data->page_mp_image)) {
            //     $image = '<img src="' . base_url() . _dir_marketing_plan . $data->page_mp_image . '" alt="' . $row->page_mp_title . '" class = "img-thumbnail img-responsive">';
            // } else
            //     $image = '';
            // echo $image;
            // echo'</div>';
            echo'<div class = "col-md-12">';
            echo'<p>' . $data->page_mp_content . '.</p>';
            echo'</div>';
            echo'</div>';
            echo'</div>';
        } else {
            echo'<div class="tab-pane fade" id="' . $data->page_mp_id . '">';
            echo'<div class = "row">';
            // echo'<div class = "col-md-12">';
            // if (!empty($data->page_mp_image)) {
            //     $image = '<img src="' . base_url() . _dir_marketing_plan . $data->page_mp_image . '" alt="' . $row->page_mp_title . '" class = "img-thumbnail img-responsive">';
            // } else
            //     $image = '';
            // echo $image;
            // echo'</div>';
            echo'<div class = "col-md-12">';
            echo'<p>' . $data->page_mp_content . '.</p>';
            echo'</div>';
            echo'</div>';
            echo'</div>';
        }
        $i++;
    }
} else {
    echo"";
}
?>

</div>
</div>


