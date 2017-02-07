<!-- widget testimonial -->
<div id="widget-testimoni" class="show_slide">
    <div class="slide">
        <ul class="testimoni-slide">
            <?php
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                $image = '<img src="' . base_url() . _dir_member . '_default2.jpg' . '">';
            ?>
                <li>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="user-text"><?php echo $row->testimony_content; ?></div>
                        </div>
                        <div class="col-md-12">
                            <div class="img-thumbnail">
                                <?php echo $image ?>
                            </div>
                            <div class="user-info">
                                <h5><strong><?php echo $row->testimony_name; ?></strong></h5>
                                <small><?php echo date_converter($row->testimony_datetime, 'l, d F Y H:i') ?></small>
                            </div>
                        </div>
                    </div>
                </li>
            <?php
                }
            } else {
                echo 'Maaf, Testimony belum dimuat.';
            }
            ?>
        </ul>
    </div>
</div>
<!-- widget testimonial -->