<div class="panel panel-default">
    <?php if (!empty($title)): ?>
    <div class="panel-heading"><h3><?php echo $title ?></h3></div>
    <?php endif ?>
    <div class="panel-body">
        <?php
        if ($query->num_rows() > 0) {
            $row = $query->row();

            if ($row->news_image != '' && file_exists(_dir_news . $row->news_image)) {
                $news_image = '<div class="text-center"><a href="' . base_url() . _dir_news . $row->news_image . '" target="_blank"><img src="' . base_url() . 'media/' . _dir_news . '520/520/' . $row->news_image . '" alt="' . $row->news_image . '" title="' . $row->news_title . '" /></a></div><br>';
            } else {
                $news_image = '';
            }
        ?>
        <h2 class="title"><?php echo $row->news_title; ?></h2>
        <br>
        <span><i class="fa fa-calendar"></i>&nbsp;<small><?php echo date_converter($row->news_input_datetime, 'l, d F Y'); ?></small>&nbsp;</span> | &nbsp; 
        <span><i class="fa fa-clock-o"></i>&nbsp; <small><?php echo date_converter($row->news_input_datetime, 'H:i'); ?> WIB</small>&nbsp;</span> | &nbsp; 
        <span><i class="fa fa-tags"></i>&nbsp; <small><a href="<?php echo base_url('news'); ?>" title="View all posts in Berita">Artikel Berita</a></small>&nbsp;</span>
        <hr>
        <?php echo $news_image; ?>
        <?php echo $row->news_content; ?>
        <?php
        } else {
            echo 'Maaf, berita belum dimuat.';
        }
        ?>
        <br>
    </div>
</div>