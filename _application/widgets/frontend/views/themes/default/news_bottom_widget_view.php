<?php if ($rs_news != false) : ?>
    <div class="news-title"><h3>News</h3></div>
    <div class="news-headline">
        <?php
        $row_news_random = $query_news_random->row();
        echo '<h3>' . $row_news_random->news_title . '</h3>';
        echo '<p>' . $row_news_random->news_short_content . '&nbsp;&nbsp;<a href="' . base_url() . 'news/detail/' . $row_news_random->news_id . '/' . url_title($row_news_random->news_title) . '">read more...</a></p>';
        ?>
    </div>
    <div class="news-item">
        <h3>Other News</h3>
        <ul>
            <?php
            foreach ($rs_news as $row_news) {
                echo '<li><a href="' . base_url() . 'news/detail/' . $row_news->news_id . '/' . url_title($row_news->news_title) . '">' . $row_news->news_title . '&nbsp;&nbsp;<small>[ ' . $row_news->news_input_date . ' ]</small></a></li>';
            }
            ?>
        </ul>
    </div>
    <div class="clear"></div>
<?php endif; ?>