<div class="panel panel-default panel-gtl" id="widget-event">
    <div class="panel-heading">
        <h4>
            <i class="fa fa-calendar"></i>
            Event Green Travellink
        </h4>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <h4 class="list-title">Kantor Pusat</h4>
                <ul class="list_headline">
                    <?php
                    if ($query_pusat->num_rows() > 0) {

                        foreach ($query_pusat->result() as $row_event) {

                            if ($row_event->event_type == 'Kantor Pusat') {

                                $date = $row_event->event_input_datetime;
                                $tahun = substr($date, 0, 4);
                                $bulan = substr($date, 5, 2);
                                $tanggal = substr($date, 8, 2);
                                if (!empty($row_event->event_image)) {
                                    $image = '<img class="img-responsive img-thumbnail" src="' . base_url() . 'media/' . _dir_event . '520/520/' . $row_event->event_image . '" class="img-responsive">';
                                } else
                                    $image = '';
                                ?>

                                <li>
                                    <span class="time"><?php echo $row_event->event_note; ?></span>
                                    <span class="title"><a href="<?php echo base_url() . 'event/detail/' . $row_event->event_id . '/' . url_title($row_event->event_title); ?>"><?php echo $row_event->event_title; ?></a></span>
                                </li>
                                <?php
                            }
                        }
                    } else {
                        echo 'Maaf, Event belum dimuat.';
                    }
                    ?>
                </ul>
            </div> <!--end col-->


            <div class="col-md-6">
                <div class="list-event">
                    <ul>
                        <?php
                        if ($query_cabang->num_rows() > 0) {

                            foreach ($query_cabang->result() as $row_event) {

                                if ($row_event->event_type == 'Kantor Cabang') {

                                    $date = $row_event->event_input_datetime;
                                    $tahun = substr($date, 0, 4);
                                    $bulan = substr($date, 5, 2);
                                    $tanggal = substr($date, 8, 2);
                                    if (!empty($row_event->event_image)) {
                                        $image = '<img class="img-responsive img-thumbnail" src="' . base_url() . 'media/' . _dir_event . '520/520/' . $row_event->event_image . '" class="img-responsive">';
                                    } else
                                        $image = '';
                                    ?>
                                    <li>
                                        <span class="time"><strong><?php echo $row_event->event_city; ?></strong>, <?php echo convert_date($row_event->event_date, 'id'); ?></span>
                                        <span class="title"><a href="<?php echo base_url() . 'event/detail/' . $row_event->event_id . '/' . url_title($row_event->event_title); ?>"><?php echo $row_event->event_title; ?></a></span>
                                    </li>
                                    
                                    <?php
                                }
                            }
                        } else {
                            echo 'Maaf, Event belum dimuat.';
                        }
                        ?>
          
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

