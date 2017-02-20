<div class="panel panel-default">
    <?php if (!empty($title)): ?>
    <div class="panel-heading"><h3><?php echo $title ?></h3></div>
    <?php endif ?>
    <div class="panel-body">
        <div id="block-product">
            <ul class="list">
                <?php 
                if(!empty($query)) {
                    foreach ($query as $row_products) {
                        if(!empty($row_products->product_image)){
                            $image = $row_products->product_image;                                
                        } else {
                            $image = 'no-image.jpg';
                        }
                        
                        $image_src = '<img src="'. base_url() . 'media/' . _dir_products . '150/150/' . $image .'" alt="'. $row_products->product_name .'" title="'. $row_products->product_name .'" height=80%" width="42">';
                        echo '<li>
                            <div class="item-list">
                                <div class="item-thumb">
                                    <a class="takezoom" href="'.base_url() . _dir_products . $image.'" rel="prettyPhoto[gallery01]" title="'.$row_products->product_name.'">'.$image_src.'</a>
                                    <span class="item-name">'.$row_products->product_name.'</span>
                                </div>
                                <div class="item-price">
                                    <span>' . substr(strip_tags($row_products->product_description), 0, strpos(strip_tags($row_products->product_description), ' ', 200)) . '...</span>
                                </div>
                                <div class="item-link">
                                    <a href="'.base_url().'products/view/'.$row_products->product_id.'/'.url_title($row_products->product_name).'" class="btn btn-default btn-sm"><i class="fa fa-ellipsis-v"></i>&nbsp; Lihat Paket</a>
                                </div>
                            </div>
                        </li>';
                        // <span class="price1">Harga : <strong>Rp '.$this->function_lib->set_number_format($row_products->product_price_member).',-</strong></span>
                    }
                } else {
                    echo '<li style="margin: 0; height: auto;"><div class="alert alert-danger">Maaf, Paket belum dimuat.</div></li>';
                }
                ?>
            </ul>
        </div>
        
        <br>
        <hr>

        <ul class="pagination">
            <?php echo $pagination ?>
        </ul> 
    </div>
</div>