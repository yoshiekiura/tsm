<div class="span8">
    <div class="titles">
        <div class="row-fluid">
            <h2><?php echo isset($page_title)?$page_title:'';?></h2>
        </div>
    </div>
    <div id="content-pages">
        <div class="desc-news" style="margin-bottom: 0;">
            <div style="display: block; padding-bottom:20px;">
                <?php
                $i = 1;
                if ($query->num_rows() > 0) {

                    echo '<div class="row-fluid">';

                    foreach ($query->result() as $row) {

                        if ($row->catalog_image != '' && file_exists(_dir_catalog . $row->catalog_image)) {
                            $image = '<img src="' . base_url() . 'media/' . _dir_catalog . '250/250/' . $row->catalog_image . '" alt="' . $row->catalog_image . '" title="' . $row->catalog_title . '">';
                        }
                        else $image = '';

                        echo '<div class="span4" style="text-align: center; padding-bottom:20px;">
                                <p><strong>' . $row->catalog_title . '</strong></p>
                                <p>' . $image . '</p>
                                <strong style="color:#c11030;">' . $row->catalog_short_description . '</strong>
                                <br>
                                <a href="' . base_url() . 'catalog/view/' . $row->catalog_id . '/' . url_title($row->catalog_title) . '" class="btn btn-block btn-large btn-warning" style="padding: 6px 9px; font-size: 16px; font-weight: bold;">Detail »</a>
                            </div>';
                    }
                    if($i % 3 == 0) echo '</div><hr><br>';

                } else {
                    echo 'Maaf, produk belum dimuat.';
                }
                ?>
            </div>
            <div class="pagination">
                <?php echo $pagination;?>
            </div>
        </div>
    </div>									
</div>