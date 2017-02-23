<div class="panel panel-default">
    <div class="panel-heading"><h3>Testimonial</h3></div>
    <div class="panel-body">
        <?php if ( ! empty($title)): ?>
            <h2 class="title"><?php echo $title ?></h2>
        <?php endif ?>

        <ul id="widget-testimoni" class="row">
            <?php
            if (!empty($query)) {
                foreach ($query->result() as $row) {
                    $image = '<img src="' . base_url() . _dir_member . '_default2.jpg' . '">';
                    ?>
                        <li class="col-md-12">
                            <div class="box">
                                <div class="box-left">
                                    <div class="img-photo">
                                        <?php echo $image; ?>
                                    </div>
                                    <p>
                                        <strong><?php echo stripslashes($row->testimony_name); ?></strong>
                                    </p>
                                </div>
                                <div class="box-right">
                                    <div class="box-thumbs"></div>
                                    <div class="box-content">
                                        <p><?php echo $row->testimony_content; ?></p>
                                        <span class="meta">- <?php echo date_converter($row->testimony_datetime, 'l, d F Y, H:i') ?> WIB -</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php
                    }
                }
                ?>
        </ul>

        <ul class="pagination">
            <?php echo $pagination; ?>
        </ul>
    </div>
</div>