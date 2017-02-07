<!-- main side -->

<div id="block-product">
    <div class="item-desc">
        <?php
        if ($query->num_rows() > 0) {
            $row = $query->row();
            {
                ?>

                <div class="item-title">
                    <h3><?php echo $row->product_name ?></h3>
                </div>
                <hr>
                <div class="item-text">
                    <div class="row">
                        <div class="col-md-4">
                            <ul class="list polaroids">
                                <?php
                                if (!empty($row->product_image)) {
                                    $image_url = '<img src="' . base_url() . 'media/' . _dir_products . '150/150/' . $row->product_image . '" alt="' . $row->product_name . '" title="' . $row->product_name . '" height=80%" width="42">';
                                    $image = $row->product_image;
                                } else {
                                    $image_url = '<img src="' . base_url() . 'media/' . _dir_products . '150/150/no-image.jpg" alt="' . $row->product_name . '" title="' . $row->product_name . '" height=80%" width="42">';
                                    $image = 'no-image.jpg';
                                }
                                ?>
                                <li>
                                    <a class='takezoom' href="<?php echo base_url() . _dir_products . $image; ?>" rel="prettyPhoto[gallery01]" title="You can add caption to pictures."><?php echo $image_url; ?></a>
                                </li>                                                
                            </ul>
                        </div>
                        <div class="col-md-8">
                            <h5 class="subtitle"><span>Harga :</span></h5>
                            <table class="table table-striped table-hovered table-bordered text-center table-harga">
                                <tbody><tr class="warning">
                                        <td>HARGA MEMBER : </td>
                                        <td>HARGA KONSUMEN :</td>
                                    </tr>
                                    <tr>
                                        <td><h3 style="font-size:20px; color:#bd2c40;">Rp. <?php echo number_format($row->product_price_member); ?>,-</h3></td>
                                        <td><h3 style="font-size:20px; color:#e58a14;">Rp. <?php echo number_format($row->product_price_non); ?>,-</h3></td>
                                    </tr>
                                </tbody></table>
                            <h5 class="subtitle"><span>Deskripsi Produk :</span></h5>
                            <p><?php echo $row->product_description; ?> </p>
                        </div>
                    </div>
                </div>

                <?php
            }
        }
        ?>

        <?php
        if ($data->num_rows() > 0) {
            ?>
            <div class="item-text">
                <h4 class="subtitle"><span>RINCIAN PRODUK :</span></h4>
                <table class="table table-bordered table-striped table-hover">
                    <tbody><tr>
                            <th style="background: #0F1012;color: #fff;" width="30%"></th>
                            <th style="background: #0F1012;color: #fff;" width="70%" class="active"><b>Keterangan</b></th>
                        </tr>

                        <?php
                        $data_row = $data->result();
                        foreach ($data_row as $item):
                            ?>
                            <tr>
                                <th rowspan="1">
                        <center>
                            <h4 class="title"><?php echo $item->product_item_name; ?> </h4>
                            <?php
                            if (!empty($item->product_item_image)) {
                                $image_item_url = '<img src="' . base_url() . 'media/' . _dir_products_item . '150/150/' . $item->product_item_image . '" alt="' . $item->product_item_name . '" title="' . $item->product_item_name . '">';
                                $image_item = $item->product_item_image;
                            } else {
                                $image_item_url = '<img src="' . base_url() . 'media/' . _dir_products_item . '150/150/no-image.jpg" alt="' . $item->product_item_name . '" title="' . $item->product_item_name . '">';
                                $image_item = 'no-image.jpg';
                            }
                            ?>
                            <a class='takezoom' rel="prettyPhoto[gallery01]" href="<?php echo base_url() . _dir_products_item . $image_item; ?>" rel="prettyPhoto[gallery01]" title="You can add caption to pictures."><?php echo $image_item_url; ?></a>
                            <div class="clearfix"></div>
                            <br>

                            <p>BPOM : <?php echo ($item->product_item_bpom == '') ? '-' : $item->product_item_bpom; ?> </p>
                            <p>Rp. <?php echo ($item->product_item_price == 0) ? '-' : number_format($item->product_item_price, 2, ",", "."); ?></p>
                        </center>        
                        </th>
                        <td>
                            <h4>
                                <span class="label label-success">
                                    <strong>Komposisi :</strong>
                                </span>
                            </h4>
                            <ul style="padding-left: 20px;">
                                <li><?php echo $item->product_item_ingredient; ?></li>
                            </ul>
                            <br>
                            <h4>
                                <span class="label label-success">
                                    <strong>Manfaat :</strong>
                                </span>
                            </h4>
                            <p><?php echo $item->product_item_benefit; ?></p>
                            <br>
                            <h4>
                                <span class="label label-success">
                                    <strong>Aturan Pakai :</strong>
                                </span>
                            </h4>
                            <p><?php echo $item->product_item_how_to_use; ?></p>
                        </td>
                        </tr>
                        <tr><td colspan="2"><br></td></tr>
                    <?php endforeach; ?>

                </table>
                <br>
            </div>
            <?php
        }
        ?>
    </div>
</div>



<!-- main side -->