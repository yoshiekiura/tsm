<?php
$generate_news = '';
if (!empty($rs_news)) {
    $i = 1;
    foreach ($rs_news as $row_news) {
        $last_menu_class = ($i >= $count) ? ' menu_kiri_akhir' : '';
        $generate_news .= '<div class="menu_kiri' . $last_menu_class . '" style="padding:7px 0 7px 0;">';
        $generate_news .= '<div style="padding:0 10px;">';
        $generate_news .= '<h3 style="text-align:left; padding:0; margin:0 0 3px 0;">' . $row_news->news_title . '</h3>';
        $generate_news .= '<div>' . $row_news->news_short_content . ' <a class="read" href="' . base_url() . 'news/detail/' . $row_news->news_id . '/' . url_title($row_news->news_title) . '">selengkapnya >></a></div>';
        $generate_news .= '</div>';
        $generate_news .= '</div>';
        $i++;
    }
}

echo $generate_news;
?>