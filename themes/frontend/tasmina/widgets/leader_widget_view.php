<?php if ($query->num_rows() > 0): ?>
<!-- Leader Widget -->
<div id="section-2">
    <div id="widget_guide">
        <div class="container">
            <h3 class="title">Pembimbing Tasbih Salam Mina</h3>
            <ul class="text-center">
                <?php
                    foreach ($query->result() as $row_leader) {

                        if (!empty($row_leader->leader_image) && file_exists(_dir_leader . $row_leader->leader_image)) {
                            $image = '<img src="' . base_url() . _dir_leader . $row_leader->leader_image . '" title="' . $row_leader->leader_name . '">';
                        } else {
                            $image = '';
                        }
                        ?>
                        <li>
                            <div class="guide_img">
                                <div class="img">
                                    <?php echo $image ?>
                                </div>
                            </div>
                            <h4><?php echo $row_leader->leader_name ?></h4>
                            <span><?php echo $row_leader->leader_position ?></span>
                        </li>
                        <?php
                    }
                ?>
            </ul>
        </div>
    </div>
</div>
<!-- End Leader Widget -->
<?php endif ?>