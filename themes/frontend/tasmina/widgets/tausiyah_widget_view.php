<!-- News Widget -->
<div role="tabpanel" class="tab-pane fade" id="content-2">
    <div class="widget_list list_article">
        <div class="row">
            <?php
            $news_row_count = $query->num_rows();
            if ($news_row_count > 0) {
                $news_data = $query->result();
                $row_news = array_shift($news_data);
                $text = substr($row_news->news_short_content, 0, 350);
                $date = date_converter($row_news->news_input_datetime, 'l, j F Y H:i');

                if (!empty($row_news->news_image) && file_exists(_dir_news . $row_news->news_image)) {
                    $image = base_url() . _dir_news .  $row_news->news_image;
                    $image = '<img src="' . $image . '" title="' . $row_news->news_title . '">';
                } else {
                    $image = '';
                }

                echo '<div class="col-md-5">
                        <div class="list_headline">
                            <div class="list_img">
                                ' . $image . '
                            </div>
                            <div class="list_text">
                                <span class="list_meta_date">' . $date . '</span>
                                <h4 class="list_title"><a href="' . base_url() . 'news/detail/' . $row_news->news_id . '/' . url_title($row_news->news_title) . '">' . $row_news->news_title . '</a></h4>
                                <span class="list_excerpt">' . $text . '</span>
                            </div>
                        </div>
                    </div>';
                echo '<div class="col-md-7"> <ul>';
                foreach ($news_data as $row_news) {
                    $text = substr($row_news->news_short_content, 0, 150);
                    $date = date_converter($row_news->news_input_datetime, 'l, j F Y H:i');
                  
                    if (!empty($row_news->news_image) && file_exists(_dir_news . $row_news->news_image)) {
                        $image = base_url() . _dir_news .  $row_news->news_image;
                        $image = '<img src="' . $image . '" title="' . $row_news->news_title . '">';
                    } else {
                        $image = '';
                    }
                    echo '<li class="item">
                        <div class="list_img">
                            ' . $image . '
                        </div>
                        <div class="list_text">
                            <h4 class="list_title"><a href="' . base_url() . 'news/detail/' . $row_news->news_id . '/' . url_title($row_news->news_title) . '">' . $row_news->news_title . '</a></h4>
                            <span class="list_meta_date">' . $date . '</span>
                        </div>
                    </li>';
                }
                echo "</ul></div>";
            } else {
                echo 'Maaf, berita belum dimuat.';
            }
            ?>
        </div>
    </div>
</div>
<!-- END News Widget -->