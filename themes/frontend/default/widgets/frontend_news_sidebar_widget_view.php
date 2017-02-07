<div class="titles">
    <div class="row-fluid">
        <h2><?php echo $widget_title;?></h2>
    </div>
</div>
<div class="well well-small" id="widget_artikel">
    <ul class="nav nav-tabs nav-stacked">
        <?php
        if(!empty($query)){
            foreach ($query as $row_news){
                echo '<li><a href="'.base_url() . 'news/detail/' . $row_news->news_id . '/' . url_title($row_news->news_title).'"><strong>'.$row_news->news_title.'</strong></a></li>';
            }
        }
        ?>
    </ul>
    <!-- <a href="http://nu-live.com/artikel/f_artikel/index">selengkapnya</a> -->

</div>
<div class="clearfix"></div>