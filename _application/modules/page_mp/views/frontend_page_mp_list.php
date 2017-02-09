<div class="panel panel-default">
    <?php if (!empty($title)): ?>
    <div class="panel-heading"><h3><?php echo $title ?></h3></div>
    <?php endif ?>
    <div class="panel-body">
        <div id="widget-mplan">
            <?php
            if (!empty($query)) {
                $i = 1;
                echo '<ul class="nav nav-tabs" role="tablist">';
                foreach ($query as $row) {
                    if ($i == 1) {

                        echo '<li class="active"><a href="#' . $row->page_mp_id . ' " role="tab" data-toggle="tab">' . $row->page_mp_title . '</a></li>';
                    } else {

                        echo '<li><a href="#' . $row->page_mp_id . ' " role="tab" data-toggle="tab">' . $row->page_mp_title . '</a></li>';
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
                if ($data->page_mp_image != '' && file_exists(_dir_marketing_plan . $data->page_mp_image)) {
                    $image_url = base_url(_dir_marketing_plan . $data->page_mp_image);
                } else {
                    $image_url = base_url(_dir_marketing_plan . '_default.jpg');
                }
                if ($i == 1) {
                    echo'<div class="tab-pane fade in active" id="' . $data->page_mp_id . '">';
                    echo'<div class="row">';
                    echo'<div class="col-md-6">';
                    echo '<a href="' . $image_url . '" rel="prettyPhoto[gallery02]" title="' . $data->page_mp_title . '" class="thumbnail">';
                    echo '<img src="' . $image_url . '" alt="' . $data->page_mp_title . '" class="img-thumbnail img-responsive">';
                    echo '</a>';
                    echo'</div>';
                    echo'<div class="col-md-6">';
                    echo'<p>' . $data->page_mp_content . '.</p>';
                    echo'</div>';
                    echo'</div>';
                    echo'</div>';
                } else {
                    echo'<div class="tab-pane fade" id="' . $data->page_mp_id . '">';
                    echo'<div class="row">';
                    echo'<div class="col-md-6">';
                    echo '<a href="' . $image_url . '" rel="prettyPhoto[gallery02]" title="' . $data->page_mp_title . '" class="thumbnail">';
                    echo '<img src="' . $image_url . '" alt="' . $data->page_mp_title . '" class="img-thumbnail img-responsive">';
                    echo '</a>';
                    echo'</div>';
                    echo'<div class="col-md-6">';
                    echo'<p>' . $data->page_mp_content . '.</p>';
                    echo'</div>';
                    echo'</div>';
                    echo'</div>';
                }
                $i++;
            }
            echo'</div>';
        }
        ?>

        </div>
    </div>
</div>