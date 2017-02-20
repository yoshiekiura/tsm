<div class="panel panel-default" id="block-list">
    <?php if (!empty($title)): ?>
    <div class="panel-heading"><h3><?php echo $title ?></h3></div>
    <?php endif ?>
    <div class="panel-body">
        <ul class="list">
            <?php
            $i = 1;
            if ($query->num_rows() > 0) {

                echo '<div class="row-fluid">';

                foreach ($query->result() as $row) {
                    $date = substr($row->news_input_datetime, 8,2);
                    $month = date_converter($row->news_input_datetime, 'M');
                   
                    if ($row->news_image != '' && file_exists(_dir_news . $row->news_image)) {
                        $news_image = '<img src="' . base_url() . 'media/' . _dir_news . '250/250/' . $row->news_image . '" alt="' . $row->news_image . '" title="' . $row->news_title . '">';
                    } else {
                        $news_image = '<img src="' . $themes_url . '/uploads/news/mekkah.jpg" alt="' . $row->news_image . '" title="' . $row->news_title . '">';
                    }

                    echo '<li>
                            <div class="item">
                                <div class="news-meta col-md-1">
                                    <h4 class="meta-date">' . $date . '</h4>
                                    <small>' . $month . '</small>
                                </div>

                                <div class="news-thumbs col-md-4">
                                    <a href="#" class="img-effect img-thumbnail" title="' . $row->news_title . '">
                                        ' . $news_image . '
                                    </a>
                                </div>

                                <div class="news-post col-md-7">
                                    <div class="description">
                                        <h4><a href="#"><strong>' . $row->news_title . '</strong></a></h4>
                                        <p style="color: #666; margin-bottom: 15px;">
                                        ' . $row->news_short_content . '
                                        </p>
                                        <p>
                                            <a href="' . base_url() . 'news/detail/' . $row->news_id . '/' . url_title($row->news_title) . '" class="btn btn-primary btn-xs">Selengkapnya &nbsp;»</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>';
                    
                }
            } else {
                echo '<li style="margin: 0; height: auto;"><div class="alert alert-danger">Maaf, Berita belum dimuat.</div></li>';
            }
            ?>
        </ul>

        <ul class="pagination">
            <?php echo $pagination; ?>
        </ul>
    </div>
</div>