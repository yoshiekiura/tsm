<div id="widget-news">
    <h2>
        Berita Terbaru <strong>Green Travellink</strong>
    </h2>
    <?php
    if ($query->num_rows() > 0) {

        foreach ($query->result() as $row_news) {
            $text = substr($row_news->news_short_content, 0, 350);
            $date = $row_news->news_input_datetime;
            $tahun = substr($date, 0, 4);
            $bulan = substr($date, 5, 2);
            $tanggal = substr($date, 8, 2);
            
          
            if (!empty($row_news->news_image)) {
                $image = '<img class="img-responsive img-thumbnail" src="' . base_url() . _dir_news .  $row_news->news_image . '" class="img-responsive">';
            } else
                $image = '';
            ?>

            <div class="item-news">
                <div class="col-md-4 no-left">
                    <a href="<?php echo base_url() . 'news/detail/' . $row_news->news_id . '/' . url_title($row_news->news_title); ?>" class="thumbnail">
                        <?php echo $image; ?>
                    </a>
                </div>
                <div class="col-md-8 no-right">
                    <h4 class="title"><a href="<?php echo base_url() . 'news/detail/' . $row_news->news_id . '/' . url_title($row_news->news_title); ?>"><?php echo $row_news->news_title; ?></a></h4>
                    <small class="meta meta-date"><i class="fa fa-calendar"></i>&nbsp; <?php echo $tanggal . ' / ' . $bulan . ' / '  . $tahun; ?></small>
                    <p class="meta meta-desc "><?php echo $text; ?></p>
                </div>
            </div>

            <?php
        }
    } else {
        echo 'Maaf, berita belum dimuat.';
    }
    ?>


</div>