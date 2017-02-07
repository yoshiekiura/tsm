<div class="widget" id="widget-promo-side">
    <div class="panel panel-default panel-gtl">
        <div class="panel-heading">
            <h4><span class="bullet"><i class="fa fa-tags"></i></span>&nbsp; Promo</h4>
        </div>
        <div class="panel-body">
            <ul class="slide">
                <?php
                if ($query->num_rows() > 0) {

                    foreach ($query->result() as $row) {
                
                            $text = substr($row->promo_content, 0, 250);
                            $date = $row->promo_input_datetime;
                            $tahun = substr($date, 0, 4);
                            $bulan = substr($date, 5, 2);
                            $tanggal = substr($date, 8, 2);
                            if (!empty($row->promo_image)) {
                                $image = '<img src="' . base_url() . _dir_promo . $row->promo_image . '">';
                            } else
                                $image = '';
                            ?>

                            <li>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="#" class="thumbnail" title="DAQU Tour & Travel">
                                            <img src='<?php echo base_url() . _dir_promo . $row->promo_image; ?>'>
                                        </a>
                                    </div>
                                    <div class="col-md-6 no-both">
                                        <h4><a href="<?php echo base_url() . 'promo/detail/' . $row->promo_id . '/' . url_title($row->promo_title); ?>"><?php echo $row->promo_short_content; ?></a></h4>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="pricing">
                                            <span>Rp. <?php echo number_format($row->promo_price); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <?php
                    }
                } else {
                    echo "<div style='font-color:black'>Maaf, Promo belum dimuat.</div>";
                }
                ?>

            </ul>
        </div>
    </div>
</div>