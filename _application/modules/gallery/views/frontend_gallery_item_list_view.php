<div class="panel panel-default">
    <?php if (!empty($gallery)): ?>
    <div class="panel-heading"><h3>Detail Galeri</h3></div>
    <?php endif ?>
    <div class="panel-body">
        <div id="block-gallery">
            <h3><?php echo $gallery->gallery_title; ?></h3>
            <div class="text-left"><i class="fa fa-clock-o"></i>&nbsp; <small><?php echo date_converter($gallery->gallery_date, 'l, d F Y') ?></small></div>
            <hr>
            <div class="item">
                <?php
                if (!empty($query)) {
                    foreach ($query as $row) {
                        echo'<div class="col-md-4 col-sm-6 col-xs-12 no-left">';
                        if (!empty($row->gallery_item_image)) {
                            $image = '<img src="' . base_url() . _dir_gallery_item . $row->gallery_item_image . '" alt="' . $row->gallery_item_title . '">';
                        } else {
                            $image = '';
                        }
                        echo'<a href="' . base_url() . _dir_gallery_item . $row->gallery_item_image . '" rel="prettyPhoto[gallery01]" title="' . $row->gallery_item_description . '" class="thumbnail">' . $image . '</a>';
                        echo'<div class="clearfix"></div>';
                        echo'<div class="share"></div>';
                        echo'</div>';
                    }
                } else {
                    echo '<div class = "alert alert-danger" role = "alert">
                    <span class = "glyphicon glyphicon-exclamation-sign" aria-hidden = "true"></span>
                    <span class = "sr-only">Error:</span>
                    Mohon Maaf, Gallery Belum Tersedia
                    </div>';
                }
                ?>
            </div>
        </div>

        <div class="pagination">
            <?php echo $pagination; ?>
        </div>
    </div>
</div>