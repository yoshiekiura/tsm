<div class="panel panel-default panel-gtl-small" id="widget-partner">
    <div class="panel-heading">
        <h4>Partner Terpilih Dan Terpercaya</h4>
    </div>
    <div class="panel-body">
        <ul class="slide">
            <?php
            if ($query->num_rows() > 0) {

                foreach ($query->result() as $row) {
                    $text = substr($row->partner_content, 0, 250);
                    $date = $row->partner_input_datetime;
                    $tahun = substr($date, 0, 4);
                    $bulan = substr($date, 5, 2);
                    $tanggal = substr($date, 8, 2);
                    if (!empty($row->partner_image)) {
                        $image = '<img class="img-responsive img-thumbnail" src="' . base_url() . _dir_partner . $row->partner_image . '" class="img-responsive">';
                    } else
                        $image = '';
                    ?>
                    <li>
                        <div class="row">
                            <div class="col-md-5">
                                <?php echo $image; ?>
                            </div>
                            <div class="col-md-7">
                                <h4><a href="<?php echo base_url() . 'partner/detail/' . $row->partner_id . '/' . url_title($row->partner_title); ?>"><?php echo $row->partner_title; ?></a></h4>
                                <p><?php echo $row->partner_short_content; ?></p>
                            </div>
                        </div>
                    </li>
                    

                    <?php
                }
            } else {
                echo 'Maaf, Partner belum dimuat.';
            }
            ?>


        </ul>
    </div>
    <div class="panel-footer">
        <div id="bx-pager-partner">
            <a data-slide-index="0" href=""><span>1</span></a>
            <a data-slide-index="1" href=""><span>2</span></a>
            <a data-slide-index="2" href=""><span>3</span></a>
        </div>
    </div>
</div>