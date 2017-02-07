<?php if ($rs_news != false) : ?>
    <div class="recent-news">
        <?php
        foreach ($rs_news as $row_news) {

            $news_title = $row_news->news_title;
            $news_short_content = $row_news->news_short_content;

            if ($row_news->news_image != '' && file_exists(_dir_news . $row_news->news_image)) {
                $news_image = $row_news->news_image;
            } else {
                $news_image = '_default.png';
            }

            echo '<div class="rnews-item">';
            echo '<img src="' . base_url() . 'media/' . _dir_news . '100/80/' . $news_image . '" alt="' . $news_image . '" title="' . $news_title . '" border="0" vspace="0" hspace="0" style="float:left; background-color:#4d4d4d; border-width:1px 1px 1px 1px; border-style:solid; border-color:#2c2c2c; padding:3px; margin:0 10px 5px 0;" />';
            echo '<h2>' . $row_news->news_input_date . ' | <a href="' . base_url() . 'news/detail/' . $row_news->news_id . '/' . url_title($news_title) . '#leave-comment">Leave a Comment</a></h2>';
            echo '<h1><a href="' . base_url() . 'news/detail/' . $row_news->news_id . '/' . url_title($news_title) . '">' . $news_title . '</a></h1>';
            echo '<p>' . nl2br($news_short_content) . '</p>';
            echo '</div>';
        }
        ?>
    </div>
<?php endif; ?>