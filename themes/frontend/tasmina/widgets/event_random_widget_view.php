<br>
<h3><i class="fa fa-calendar"></i>&nbsp; Event Lainnya</h3>
<hr>
<ul class="listEvents">
    <?php
    if (!empty($query_primer)) {
        $no = 1;
        foreach ($query_primer as $row) {
            $text = substr($row->event_description, 0, 250);
            if ($row->event_image != '' && file_exists(_dir_event . $row->event_image)) {
                $image_url = base_url() . 'media/' . _dir_event . '250/250/' . $row->event_image;
                $event_image = '<img src="' . base_url() . 'media/' . _dir_event . '250/250/' . $row->event_image . '" alt="' . $row->event_image . '" title="' . $row->event_title . '">';
            } else {
                $image_url = base_url() . _dir_event . 'no_image.png';
                $event_image = '<img src="' . base_url() . _dir_event . 'no_image.png' . '" class="thumbnail">';
            }
            ?>
            <li>
                <div class="col-md-4">
                    <div class="thumbs-event img-thumbnail">
                        <img src="<?php echo $image_url; ?> " alt="<?php echo $row->event_title; ?> ">
                        <a href="<?php echo $image_url; ?> " rel="prettyPhoto[gallery01]" title="<?php echo $row->event_title; ?> "><i class="fa fa-search-plus"></i></a>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="desc-event">
                        <h4 class="title-event"><a href="<?php echo base_url() . 'event/detail/' . $row->event_id . '/' . url_title($row->event_title); ?>"><?php echo $row->event_title; ?> </a></h4>
                        <span><label>Tanggal</label><i class="fa fa-calendar"></i> <?php echo date_converter($row->event_input_date, 'l, d F Y') ; ?></span>
                        <span><label>Waktu</label><i class="fa fa-clock-o"></i> <?php echo $row->event_time; ?></span>
                        <span><label>Kota</label><i class="fa fa-map-marker"></i> <?php echo $row->event_city; ?></span>
                    </div>
                </div>
            </li>
            <?php
        }
    }else {
        echo "Event tidak ditemukan";
    }
    ?>
</ul>