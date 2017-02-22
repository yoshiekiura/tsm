<!-- Product Widget -->
<div role="tabpanel" class="tab-pane fade" id="content-3">
    <div class="widget_list list_product">
        <div class="row">
            <?php
            if ($query->num_rows() > 0) {

                foreach ($query->result() as $row_product) {

                    if (!empty($row_product->product_image) && file_exists(_dir_products . $row_product->product_image)) {
                        $image = '<img src="' . base_url() . _dir_products . $row_product->product_image . '" title="' . $row_product->product_name . '">';
                    } else {
                        $image = '';
                    }

                    $desc_no_html = strip_tags($row_product->product_description);
                    $pos = (strlen($desc_no_html) > 275) ? strpos($desc_no_html, ' ', 275) : 275;
                    $preview_text = (strlen($desc_no_html) > 275) ? substr($desc_no_html, 0, $pos) . '...' : $desc_no_html;
                    ?>
                    <div class="col-md-4">
                        <div class="item">
                            <h4 class="list_title"><a href="#"><?php echo $row_product->product_name ?></a></h4>
                            <div class="list_img">
                                <?php echo $image ?>
                            </div>
                            <div class="list_text">
                                <span class="list_excerpt"><?php echo $preview_text ?></span>
                                <a href="<?php echo base_url() . 'products/view/' . $row_product->product_id . '/' . url_title($row_product->product_name); ?>" class="btn btn-default btn-sm"><i class="fa fa-ellipsis-v"></i>&nbsp; selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo 'Maaf, Paket belum dimuat.';
            }
            ?>
        </div>
    </div>
</div>
<!-- End Product Widget -->