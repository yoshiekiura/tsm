<div class="row-fluid">
    <div class="widget widget_welcome">
        <div class="titles">
            <h2><?php echo $widget_title;?></h2>
        </div>
        <ul>
            <?php
            if(!empty($query)){
                foreach ($query as $row){
                    $content = strip_tags($row->page_home_content);
                    $value_content = (strlen($content) > 550) ? substr($content, 0, 550) . '...' : $content;
            ?>
            <li>
                <h4><?php echo $row->page_home_title;?></h4><br>
                <div class="row-fluid">
                    <div class="span8 pull-right">
                        <?php 
                        echo $value_content;
                        echo '<p><b>[<a href="' . base_url() . 'page/view/' . $row->page_home_id . '/' . url_title($row->page_home_title) . '">baca selengkapnya...</a>]</b></p>';
                        ?>
                    </div>
                </div>
            </li>
            <?php
                }
            }
            ?>
        </ul>														
    </div>						
</div>