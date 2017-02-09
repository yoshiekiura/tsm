<!-- Gallery Widget -->
<div role="tabpanel" class="tab-pane fade" id="content-5">
    <div class="widget_list list_thumbnail">
        <div class="row">
            <?php
            if ($query->num_rows() > 0) {

                foreach ($query->result() as $row_gallery) {

                        if (!empty($row_gallery->gallery_image) && file_exists(_dir_gallery . $row_gallery->gallery_image)) {
                            $image = '<img src="' . base_url() . _dir_gallery . $row_gallery->gallery_image . '" title="' . $row_gallery->gallery_title . '">';
                        } else {
                            $image = '';
                        }
                        ?>
                        <div class="col-md-3">
                            <div class="item">
                                <a href="<?php echo base_url() . 'gallery/detail_gallery/' . $row_gallery->gallery_id . '/' . url_title($row_gallery->gallery_title); ?>">
                                    <div class="list_img">
                                        <?php echo $image ?>
                                        <div class="list_text">
                                            <span class="list_meta_date"><?php echo date_converter($row_gallery->gallery_date, 'd F Y') ?></span>
                                            <h4 class="list_title"><?php echo $row_gallery->gallery_title ?></h4>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php
                }
            } else {
                echo 'Maaf, Galeri belum dimuat.';
            }
            ?>
        </div>
    </div>
</div>
<!-- End Gallery Widget -->