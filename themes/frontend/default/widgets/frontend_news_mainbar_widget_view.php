<div class="row-fluid">
    <div class="span12">
        <div class="titles">
            <h2><?php echo $widget_title;?></h2>
        </div>
        <div class="row-fluid">
            <?php
            if (!empty($query_primer)) {
                foreach ($query_primer as $row_news) {
                    if(!empty($row_news->news_image)){
                        $image = '<img src="'.base_url().'media/' . _dir_news . '520/520/'.$row_news->news_image.'">';
                    }
                    else $image = '';
            ?>
            <div class="span7">
                <div id="content_news">
                    <?php echo $image;?>
                    <div class="desc-news" style="margin-bottom: 0;">
                        <?php
                            echo '<h4>'.$row_news->news_title.'</h4>';
                            echo $row_news->news_short_content;
                            echo '<p><b>[<a href="' . base_url() . 'news/detail/' . $row_news->news_id . '/' . url_title($row_news->news_title) . '">baca selengkapnya...</a>]</b></p>';
                        ?>
                        <div class="metapost">
                            <span class="first">Posted at <?php echo $row_news->news_input_date; ?></span> | 
                            <span>Categories : <a href="<?php echo $themes_url; ?>news" title="View all posts in Berita" rel="category tag">Artikel Berita</a></span>
                        </div>
                    </div>														
                </div>
            </div>
            <?php
                }
                if (!empty($query_sub)) {
            ?>
            <div class="span5">
                <div id="widget_news" style="padding-left: 10px;">
                    <h4><?php echo $widget_sub_title;?></h4>
                    <ul>
                    <?php
                    foreach ($query_sub as $sub_news) {
                        if(!empty($sub_news->news_image)){
                            $image_sub = '<img src="'.base_url().'media/' . _dir_news . '250/250/'.$sub_news->news_image.'" style="border: 1px solid #DDD; padding: 1px; background: #FFF;">';
                        }
                        else $image_sub = '';
                    ?>
                        <li>
                            <div class="row-fluid">
                                <div class="span5"><a href="<?php echo base_url() . 'news/detail/' . $sub_news->news_id . '/' . url_title($sub_news->news_title);?>"> <?php echo $image_sub;?></a> </div>
                                <div class="span7 pull-right">
                                    <?php
                                        echo '<a href="'.base_url() . 'news/detail/' . $sub_news->news_id . '/' . url_title($sub_news->news_title).'">'.$sub_news->news_title.'</a>';
                                        echo '<small>'.$sub_news->news_short_content.'</small>';
                                    ?>
                                </div>
                            </div>
                        </li>
                    <?php
                    }
                    ?>
                    </ul>														
                </div>
                <div class="clearfix"><br></div>									
            </div>
            <?php
                }
            }
            ?>
        </div>	
    </div>
</div>
<div class="clearfix"><br></div>