<div class="span8">
    <?php
    if ($query->num_rows() > 0) {
        $row = $query->row();

        if ($row->catalog_image != '' && file_exists(_dir_catalog . $row->catalog_image)) {
            $catalog_image = '<a href="' . base_url() . _dir_catalog . $row->catalog_image . '" target="_blank"><img src="' . base_url() . 'media/' . _dir_catalog . '600/600/' . $row->catalog_image . '" alt="' . $row->catalog_image . '" title="' . $row->catalog_title . '" /></a>';
        } else {
            $catalog_image = '';
        }
        ?>
    <div class="titles">
        <div class="row-fluid">
            <h2><?php echo isset($page_title)?$page_title:'';?></h2>
        </div>
    </div>
    <div id="content-pages">
        <div class="desc-news" style="margin-bottom: 0;">
            <div class="well small-well">
                <div class="row-fluid">
                    <div class="span12">
                        <div id="content_news">
                            <?php echo $catalog_image; ?>
                            <div class="desc-news" style="margin-bottom: 0;">
                                <h4><strong><?php echo $row->catalog_title; ?></strong></h4>
                                <?php echo $row->catalog_description; ?>
                                <div class="metapost">
                                    <span>Categories : <a href="<?php echo base_url(); ?>catalog" title="View all posts in Catalog" rel="category tag">Featured product</a></span>
                                </div>
                            </div>														
                        </div>
                    </div>													
                </div>
            </div>
        </div>														
    </div>
    <?php
    } else {
        echo 'Maaf, produk belum dimuat.';
    }
    ?>
</div>

