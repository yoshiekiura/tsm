<!-- Event Widget -->
<div role="tabpanel" class="tab-pane fade" id="content-4">
    <div class="widget_list list_thumbnail">
        <div class="row">
            <?php
            if ($query_pusat->num_rows() > 0) {

                foreach ($query_pusat->result() as $row_event) {

                    // if ($row_event->event_type == 'Kantor Pusat') {

                        if (!empty($row_event->event_image) && file_exists(_dir_event . $row_event->event_image)) {
                            $image = '<img src="' . base_url() . _dir_event . $row_event->event_image . '" title="' . $row_event->event_title . '">';
                        } else {
                            $image = '';
                        }
                        ?>
                        <div class="col-md-3">
                            <div class="item">
                                <a href="<?php echo base_url() . 'event/detail/' . $row_event->event_id . '/' . url_title($row_event->event_title); ?>">
                                    <div class="list_img">
                                        <?php echo $image ?>
                                        <div class="list_text">
                                            <span class="list_meta_date"><?php echo date_converter($row_event->event_date, 'd F Y') ?></span>
                                            <h4 class="list_title"><?php echo $row_event->event_title ?></h4>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php
                    // }
                }
            } else {
                echo 'Maaf, Event belum dimuat.';
            }
            ?>
        </div>
    </div>
</div>
<!-- End Event Widget -->