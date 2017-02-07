<div id="widget_feature">
    <div class="row-fluid">
        <div class="span12">
            <div class="titles">
                <div class="row-fluid">
                    <h2><?php echo $widget_title;?></h2>
                </div>
            </div>
            <div>
                <ul class="posts-grid row-fluid unstyled news">
                <?php
                if(!empty($query)){
                    foreach ($query as $row){
                        echo '<li class="span4 item_1">
                                <figure class="featured-thumbnail thumbnail">
                                    <img src="'.base_url().'media/'._dir_catalog.'288/288/'.$row->catalog_image.'" alt="'.$row->catalog_image.'"><span class="zoom-icon"></span>
                                </figure>
                                <div class="clear"></div>
                                <h5>'.$row->catalog_title.'</h5>
                                <p class="excerpt">'.$row->catalog_short_description.'</p>
                                <a href="'.base_url().'catalog/view/'.$row->catalog_id.'" class="btn btn-primary" title="'.$row->catalog_title.'">more</a>
                            </li>';
                    }
                }
                ?>
                </ul>
            </div>
        </div>
    </div>
</div>