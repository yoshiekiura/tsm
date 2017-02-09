<div class="panel panel-default">
    <?php if (!empty($title)): ?>
    <div class="panel-heading"><h3><?php echo $title ?></h3></div>
    <?php endif ?>
    <div class="panel-body">
        <div id="block-product">
            <div class="item-desc">
                <?php
                if ($query->num_rows() > 0) {
                    $row = $query->row();
                    {
                        ?>
                        <div class="item-title">
                            <h3 class="title"><?php echo $row->product_name ?></h3>
                        </div>
                        <hr>
                        <div class="item-text">
                            <div class="row">
                                <div class="col-md-4">
                                    <ul class="list polaroids">
                                        <?php
                                        if (!empty($row->product_image)) {
                                            $image_url = '<img src="' . base_url() . 'media/' . _dir_products . '250/250/' . $row->product_image . '" alt="' . $row->product_name . '" title="' . $row->product_name . '">';
                                            $image = $row->product_image;
                                        } else {
                                            $image_url = '<img src="' . base_url() . 'media/' . _dir_products . '250/250/no-image.jpg" alt="' . $row->product_name . '" title="' . $row->product_name . '">';
                                            $image = 'no-image.jpg';
                                        }
                                        ?>
                                        <li>
                                            <a class='takezoom' href="<?php echo base_url() . _dir_products . $image; ?>" rel="prettyPhoto[gallery01]" title="<?php echo $row->product_name ?>"><?php echo $image_url; ?></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-8">
                                    <?php if ($row->product_price_member != 0 && $row->product_price_non != 0): ?>
                                        <h5 class="subtitle"><span>Harga :</span></h5>
                                        <table class="table table-striped table-hovered table-bordered text-center table-harga">
                                            <tbody><tr class="warning">
                                                    <td>HARGA MEMBER : </td>
                                                    <td>HARGA KONSUMEN :</td>
                                                </tr>
                                                <tr>
                                                    <td><h3 style="font-size:20px; color:#bd2c40;">Rp. <?php echo $row->product_price_member == 0 ? '-' : $this->function_lib->set_number_format($row->product_price_member); ?>,-</h3></td>
                                                    <td><h3 style="font-size:20px; color:#e58a14;">Rp. <?php echo $row->product_price_non == 0 ? '-' : $this->function_lib->set_number_format($row->product_price_non); ?>,-</h3></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br>
                                    <?php endif ?>

                                    <h5 class="subtitle"><span>Deskripsi :</span></h5>
                                    <p><?php echo $row->product_description; ?> </p>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                }
                ?>
            </div>
        </div>  
    </div>
</div>