<div class="panel panel-default">
    <?php if (!empty($title)): ?>
    <div class="panel-heading"><h3><?php echo $title ?></h3></div>
    <?php endif ?>
    <div class="panel-body">
        <ul class="list-group">
            <?php
            $i = 1;
            if ($query->num_rows() > 0) {

                foreach ($query->result() as $row) {
                    echo ' <li class="list-group-item" style="width:25%">
                      <span class="badge">'.$row->downloads_count.'</span><a href="' . base_url() . 'downloads/getfile/' . $row->downloads_id . '/' . $row->downloads_file . '">'. $row->downloads_title .'</a>
                        
                    </li><br>';
                }
            } else {

                echo 'Maaf, File Download belum tersedia.';
            }
            ?>
        </ul>

        <ul class="pagination">
            <?php echo $pagination; ?>
        </ul>
    </div>
</div>