<div class="span8">
    <div class="titles">
        <div class="row-fluid">
            <h2><?php echo isset($page_title)?$page_title:'';?></h2>
        </div>
    </div>
    <div class="row-fluid">
        <ul class="gallery clearfix">
            <?php
            if(!empty($query)){
                foreach ($query as $row){
                    if(!empty($row->gallery_item_image)){
                        $image = '<img src="'. base_url() . 'media/' . _dir_gallery_item . '150/150/' . $row->gallery_item_image .'" alt="'. $row->gallery_item_title .'" title="'. $row->gallery_item_title .'">';
                    }
                    else $image = '';

                    echo '<li><a href="'. base_url() . _dir_gallery_item . $row->gallery_item_image .'" rel="prettyPhoto[gallery1]">' . $image . '</a></li> ';
                }
            }
            ?>
        </ul>

    </div>
    <div class="pagination">
        <?php echo $pagination;?>
    </div>
    <br><hr>
    <div class="select-gallery">
        <select id="select-category" name="kat_gale">
            <option value="0" selected="">Pilih Kategori</option>
            <?php
            if(!empty($category)){
                foreach ($category as $cat){
                    echo '<option value="'.$cat->gallery_id.'">'.$cat->gallery_title.'</option>';
                }
            }
            ?>
        </select>
    </div>
    <div class="row-fluid">											
        <ul class="posts-grid row-fluid unstyled gallery">
            <?php
            if(!empty($category)){
                foreach ($category as $row_cat){
                    if(!empty($row_cat->gallery_image)){
                        $image_cat = '<img src="'. base_url() . 'media/' . _dir_gallery . '200/200/' . $row_cat->gallery_image .'" class="attachment-thumbnail" alt="'. $row_cat->gallery_image .'" title="'. $row_cat->gallery_title .'" style="height: auto; width: 100%;">';
                    }
                    else $image_cat = '';

                    echo '<li class="span4 item_1">
                            <a href="'. base_url() .'gallery/category/'. $row_cat->gallery_id .'" title="'. $row_cat->gallery_title .'"><figure class="featured-thumbnail thumbnail">
                                ' . $image_cat . '<span class="zoom-icon"></span></figure></a>
                            <div class="clear"></div>
                            <h5>'. $row_cat->gallery_title .'</h5>
                        </li>';
                }
            }
            ?>
        </ul>
    </div>
    <script type="text/javascript">
        var selectmenu = document.getElementById("select-category")
        selectmenu.onchange = function() {
            var chosenoption = this.options[this.selectedIndex];
            document.location = '<?php echo base_url();?>gallery/category/' + chosenoption.value;
        }
    </script>										
</div>