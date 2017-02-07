<?php
if(!empty($query)){
?>
    <div class="widget">
        <div class="well well-small" id="widget_menu">
            <div class="titles">
                <div class="row-fluid">
                    <h2><?php echo $widget_title;?></h2>
                </div>
            </div>
            <div>
                <?php
                echo '<img src="'.base_url().'media/'._dir_catalog.'288/288/'.$query->catalog_image.'" alt="'.$query->catalog_image.'"><span class="zoom-icon"></span>';
                ?>
                <div class="desc-news" style="margin-bottom: 0;">
                    <h5><strong><?php echo $query->catalog_title;?></strong></h5>
                    <p><?php echo $query->catalog_short_description;?></p>
                    <p><b>[<a href="<?php echo base_url().'catalog/view/'.$query->catalog_id;?>">baca selengkapnya...</a>]</b></p>																	

                </div>														
            </div>
        </div>										
    </div>
    <div class="clearfix"></div>
<?php 
}
?>