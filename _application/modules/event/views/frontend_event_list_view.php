<div class="panel panel-default" id="block-list">
    <?php if (!empty($title)): ?>
    <div class="panel-heading"><h3><?php echo $title ?></h3></div>
    <?php endif ?>
    <div class="panel-body">
        <ul class="list listEvents">
            <?php
            $i = 1;
            if ($query->num_rows() > 0) {

                foreach ($query->result() as $row) {
                    $years = substr($row->event_input_datetime, 0,4);
                    $date = substr($row->event_input_datetime, 8,2);
                    $month = substr($row->event_input_datetime, 5,2);

                    $text = substr($row->event_description, 0, 250);
                    if ($row->event_image != '' && file_exists(_dir_event . $row->event_image)) {
                        $image_url = base_url() . 'media/' . _dir_event . '250/250/' . $row->event_image;
                        $event_image = '<img src="' . base_url() . 'media/' . _dir_event . '250/250/' . $row->event_image . '" alt="' . $row->event_image . '" title="' . $row->event_title . '">';
                    } else {
                        $image_url = base_url() . _dir_event . 'no_image.png';
                        $event_image = '<img src="' . base_url() . _dir_event . 'no_image.png' . '" class="thumbnail">';
                    }

                    echo '<li>
                        <div class="col-md-4">
                            <div class="thumbs-event img-thumbnail">
                            ' . $event_image . '
                            <img src="' . $image_url . '" alt="' . $row->event_title . '">
                                <a href="' . $image_url . '" rel="prettyPhoto[gallery01]" title="' . $row->event_title . '"><i class="fa fa-search-plus"></i></a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="desc-event">
                                <h4 class="title-event"><a href="' . base_url() . 'event/detail/' . $row->event_id . '/' . url_title($row->event_title) . '">' . $row->event_title . '</a></h4>
                                <span><label>Tanggal</label><i class="fa fa-calendar"></i> ' . date_converter($row->event_input_date, 'l, d F Y') . ' </span>
                                <span><label>Waktu</label><i class="fa fa-clock-o"></i> ' . $row->event_time . '</span>
                                <span><label>Kota</label><i class="fa fa-map-marker"></i> ' . $row->event_city . '</span>
                            </div>
                        </div>
                    </li>';
                }

            } else {
                echo 'Maaf, Agenda belum dimuat.';
            }
            ?>
        </ul>

        <ul class="pagination">
            <?php echo $pagination; ?>
        </ul>
    </div>
</div>