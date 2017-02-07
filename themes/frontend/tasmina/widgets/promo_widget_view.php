<div id="widget-reward">
    <!-- List Promo -->
    <div class="panel panel-default" id="list_promo">
        <div class="panel-body">
            <div class="row">
                <?php
                if ($query->num_rows() > 0) {

                    foreach ($query->result() as $row) {
                        $text = substr($row->promo_content, 0, 80);
                        $date = $row->promo_input_datetime;
                        $tahun = substr($date, 0, 4);
                        $bulan = substr($date, 5, 2);
                        $tanggal = substr($date, 8, 2);
                        if (!empty($row->promo_image)) {
                            $image = '<img class="img-responsive img-thumbnail" src="' . base_url() . _dir_promo . $row->promo_image . '" class="img-responsive">';
                        } else
                            $image = '';
                        ?>
                        <div class="col-md-3">
                            <div class="img-reward">
                                <div class="thumbnail">
                                    <?php echo $image; ?>
                                </div>
                                <div class="excerpt">
                                    <h5><a href="<?php echo base_url() . 'promo/detail/' . $row->promo_id . '/' . url_title($row->promo_title); ?>"><?php echo $row->promo_title; ?></a></h5>
                                    <small><?php echo $text . '...'; ?> <a href="<?php echo base_url() . 'promo/detail/' . $row->promo_id . '/' . url_title($row->promo_title); ?>">Selengkapnya &nbsp;<i class="fa fa-angle-double-right"></i></a></small>
                                </div>
                                <div class="pricing">
                                    <span>Rp. <?php echo number_format($row->promo_price); ?></span>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                } else {
                    echo 'Maaf, Promo belum dimuat.';
                }
                ?>
            </div>

            <div class="nav-slide">
                <span class="nav-prev _2nd"></span>
                <span class="nav-next _2nd"></span>
            </div>
        </div>
        <div class="panel-footer">
            <div class="show-rates">
                <div class="rates-val">
                    <?php

                    function bacaHTML($url) {
                        // inisialisasi CURL 
                        $data = curl_init();
                        // setting CURL 
                        curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($data, CURLOPT_URL, $url);
                        // menjalankan CURL untuk membaca isi file 
                        $hasil = curl_exec($data);
                        curl_close($data);
                        return $hasil;
                    }

                    $kodeHTML = bacaHTML('http://www.klikbca.com');
                    $pecah = explode('<table width="139" border="0" cellspacing="0" cellpadding="0">', $kodeHTML);

                    $pecahLagi = explode('</table>', $pecah[2]);


                    $kurs = substr($pecahLagi[0], 120, 100);
                    //echo $kurs;
//membuat fungsi grabbing dengan curl
//                    function grabCURL($url) {
//                        $ch = curl_init();
//                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//                        curl_setopt($ch, CURLOPT_URL, $url);
//                        curl_setopt($ch, CURLOPT_HEADER, 0);
//                        $grab = curl_exec($ch);
//                        curl_close($ch);
//                        return $grab;
//                    }
//
//                    //membuat fungsi explode dengan multiple delimiter (pembatas)
//                    function explodeX($delimiters, $string) {
//                        return explode(chr(1), str_replace($delimiters, chr(1), $string));
//                    }
//
//                    $hasil = grabCURL('http://www.bca.co.id/id/Individu/Sarana/Kurs-dan-Suku-Bunga/Kurs-dan-Kalkulator');
//
//                    //pecah string hasil grabbing ke array
//                    $pecah = explodeX(array(' <tbody class="text-right">', '</tbody>'), $hasil);
//
//                    $kurs = substr($pecah[1], 177, 9);


                    echo'<span>Kurs Hari Ini</span>';
                    echo'<span>1 USD = Rp ' . $kurs . '</span>';
                    ?>
                </div>
                <div class="rates-nav">
                    <a href="<?php echo base_url(); ?>page/view/25/jadwal-umrah-terbaru"><i class="fa fa-chevron-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- List Promo -->
</div>