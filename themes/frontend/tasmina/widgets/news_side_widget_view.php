<div class="widget" id="widget-news-side">
    <div class="panel panel-default panel-gtl">
        <div class="panel-heading">
            <h4><span class="bullet"><i class="fa fa-volume-up"></i></span>&nbsp; Berita Terbaru</h4>
        </div>
        <div class="panel-body">
            <ul class="slide">
                <?php
                if ($query->num_rows() > 0) {

                    foreach ($query->result() as $row) {
                        $text = substr($row->news_content, 0, 250);
                        $date = $row->news_input_datetime;
                        $tahun = substr($date, 0, 4);
                        $bulan = substr($date, 5, 2);
                        $tanggal = substr($date, 8, 2);
                        if (!empty($row->news_image)) {
                            $image = '<img class="thumbnail" src="' . base_url() . _dir_news . $row->news_image . '" class="img-responsive">';
                        } else
                            $image = '';
                        ?>
                        <li>
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="#" class="thumbnail" title="DAQU Tour & Travel">
                                        <?php echo $image; ?>
                                    </a>
                                </div>
                                <div class="col-md-6 no-both">
                                    <h4><a href="<?php echo base_url() . 'news/detail/' . $row->news_id . '/' . url_title($row->news_title); ?>"><?php echo $row->news_short_content; ?></a></h4>
                                </div>
                            </div>
                        </li>

                        <?php
                    }
                } else {
                    echo 'Maaf, Promo belum dimuat.';
                }
                ?>



            </ul>
        </div>
    </div>
</div>