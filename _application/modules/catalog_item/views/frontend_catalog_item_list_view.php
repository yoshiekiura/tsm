<div class="panel-body">
    <div id="block-gallery">        
        <ul class="gallery_cover">
            <?php
            if (!empty($query)) {
                foreach ($query as $row) {
                    $dayList = array(
                        'Sun' => 'Minggu',
                        'Mon' => 'Senin',
                        'Tue' => 'Selasa',
                        'Wed' => 'Rabu',
                        'Thu' => 'Kamis',
                        'Fri' => 'Jumat',
                        'Sat' => 'Sabtu'
                    );
                    $day = date('D', strtotime($row->catalog_item_date));
                    echo'<li class="col-md-10 col-sm-6 col-xs-12 no-left">';
                    if (!empty($row->catalog_item_image)) {
                        $image = '<img src="' . base_url() . _dir_catalog_item . $row->catalog_item_image . '" alt="' . $row->catalog_item_title . '" title="' . $row->catalog_item_title . '">';
                    } else
                        $image = '';
                    echo' <div class="cover">';
                    echo'<span><a href="' . base_url() . 'catalog_item/detail_catalog_item/' . $row->catalog_item_id . '" title="View Album">';
                    echo $image;
                    echo'<div class="cover_title">' . $row->catalog_item_title . '</div>
                    </a></span></div>';
                    echo '<span style="display: block;margin-top: 5px;margin-left: 10px;"><i class="fa fa-calendar"></i>&nbsp; <small>' . $dayList[$day] . ',' . ' ' . convert_datetime($row->catalog_item_date, 'id') . '</small>&nbsp;</span>
                    </li>';
                }
            } else {
                echo '<div class = "alert alert-danger" role = "alert">
                <span class = "glyphicon glyphicon-exclamation-sign" aria-hidden = "true"></span>
                <span class = "sr-only">Error:</span>
                Mohon Maaf, Katalog Belum Tersedia
                </div>';
            }
            ?>
            <div class="clearfix"></div>
        </ul>
    </div>
</div>