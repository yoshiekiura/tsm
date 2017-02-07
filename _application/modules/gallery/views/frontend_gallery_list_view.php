<div class="panel panel-default">
    <?php if (!empty($title)): ?>
    <div class="panel-heading"><h3><?php echo $title ?></h3></div>
    <?php endif ?>
    <div class="panel-body">
        <div id="block-gallery">
            <div class="text-left">Daftar Album Gallery Foto</div>
            <hr>
            <ul class="gallery_cover">
                <?php
                if (!empty($query)) {
                    foreach ($query as $row) {
                        echo'<li class="col-md-4 col-sm-6 col-xs-12 no-left">';
                        if (!empty($row->gallery_image)) {
                            $image = '<img src="' . base_url() . _dir_gallery . $row->gallery_image . '" alt="' . $row->gallery_title . '" title="' . $row->gallery_title . '">';
                        } else {
                            $image = '';
                        }
                        echo' <div class="cover">';
                        echo'<span><a href="' . base_url() . 'gallery/detail_gallery/' . $row->gallery_id . '" title="View Album">';
                        echo $image;
                        echo'<div class="cover_title">' . $row->gallery_title . '</div></a></span></div>';
                        echo '<span style="display: block;margin-top: 5px;margin-left: 10px;"><i class="fa fa-calendar"></i>&nbsp; <small>' . date_converter($row->gallery_date, 'l, d F Y') . '</small>&nbsp;</span>
                        </li>';
                    }
                } else {
                    echo '<div class = "alert alert-danger" role = "alert">
                    <span class = "glyphicon glyphicon-exclamation-sign" aria-hidden = "true"></span>
                    <span class = "sr-only">Error:</span>
                    Mohon Maaf, Gallery Belum Tersedia
                    </div>';
                }
                ?>
                <div class="clearfix"></div>
            </ul>
        </div>
    </div>
</div>