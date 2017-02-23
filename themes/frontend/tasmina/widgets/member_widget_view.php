<div class="col-md-3 stats">
    <h4 class="title"><i class="fa fa-users"></i>&nbsp; Member<strong> Baru</strong></h4>
    <div class="scroll-list-2 scroll-text">
        <ul>
            <?php
            $image_dir = base_url() . 'media/' . _dir_member . '160/160/';
            if ($query->num_rows() > 0) {
                $i=1;
                foreach ($query->result() as $row) {
                    $detail = $this->mlm_function->get_arr_member_detail($row->network_id); 
                    if(!empty($detail['member_image']) && file_exists(_dir_member . $detail['member_image'])){
                        $image_url = $image_dir . $detail['member_image'];
                    } else {
                        $image_url = $themes_url . '/images/no_photo.png';
                    }
            ?>
                <li>
                    <div class="badge badge-success"><?php echo $i++; ?></div>
                    <div class="member_img">
                        <img src="<?php echo $image_url;?>" alt="<?php echo stripslashes($row->member_name); ?>">
                    </div>
                    <div class="member_id">
                        <h4><?php echo stripslashes($row->member_name); ?> (<?php echo $row->network_code; ?>)</h4>
                        <span><?php echo convert_date($row->member_join_datetime,'id'); ?></span>
                    </div>
                </li>
            <?php
                }
            } else {
                // echo 'Belum ada Pendaftaran.';
            }

            // dummy
            if ($i <= 10) {
                $image_url = $themes_url . '/images/no_photo.png';
                for ($j=$i; $j <= 10; $j++) { 
                    ?>
                        <li>
                            <div class="badge badge-success"><?php echo $j; ?></div>
                            <div class="member_img">
                                <img src="<?php echo $image_url;?>" alt="-">
                            </div>
                            <div class="member_id">
                                <h4>-</h4>
                                <span>-</span>
                            </div>
                        </li>
                    <?php
                }
            }
            ?>
        </ul>
    </div>
</div>

<div class="col-md-3 stats">
    <h4 class="title"><i class="fa fa-users"></i>&nbsp; Top<strong> Income</strong></h4>
    <div class="scroll-list-3 scroll-text">
        <ul>
            <?php
            $i=1;
            if ($top_income->num_rows() > 0) {
                foreach ($top_income->result() as $row) {
                    $detail = $this->mlm_function->get_arr_member_detail($row->network_id); 
                    if(!empty($detail['member_image']) && file_exists(_dir_member . $detail['member_image'])){
                        $image_url = $image_dir . $detail['member_image'];
                    } else {
                        $image_url = $themes_url . '/images/no_photo.png';
                    }
            ?>
                <li>
                    <div class="badge badge-success"><?php echo $i++; ?></div>
                    <div class="member_img">
                        <img src="<?php echo $image_url;?>" alt="<?php echo stripslashes($row->member_name); ?>">
                    </div>
                    <div class="member_id">
                        <h4><?php echo stripslashes($row->member_name); ?> (<?php echo $row->network_code; ?>)</h4>
                        <!-- <span><?php echo $this->function_lib->set_number_format($row->total_bonus); ?></span> -->
                        <span>-</span>
                    </div>
                </li>
            <?php
                }
            } else {
                // echo 'Belum ada Pendaftaran.';
            }

            // dummy
            if ($i <= 10) {
                $image_url = $themes_url . '/images/no_photo.png';
                for ($j=$i; $j <= 10; $j++) { 
                    ?>
                        <li>
                            <div class="badge badge-success"><?php echo $j; ?></div>
                            <div class="member_img">
                                <img src="<?php echo $image_url;?>" alt="-">
                            </div>
                            <div class="member_id">
                                <h4>-</h4>
                                <span>-</span>
                            </div>
                        </li>
                    <?php
                }
            }
            ?>
        </ul>
    </div>
</div>
<div class="col-md-3 stats">
    <h4 class="title"><i class="fa fa-users"></i>&nbsp; Top<strong> Sponsor</strong></h4>
    <div class="scroll-list-3 scroll-text">
        <ul>
            <?php
            $i=1;
            if ($top_sponsor->num_rows() > 0) {
                foreach ($top_sponsor->result() as $row) {
                    $detail = $this->mlm_function->get_arr_member_detail($row->network_sponsor_network_id); 
                    if(!empty($detail['member_image']) && file_exists(_dir_member . $detail['member_image'])){
                        $image_url = $image_dir . $detail['member_image'];
                    } else {
                        $image_url = $themes_url . '/images/no_photo.png';
                    }
            ?>
                <li>
                    <div class="badge badge-success"><?php echo $i++; ?></div>
                    <div class="member_img">
                        <img src="<?php echo $image_url;?>" alt="<?php echo stripslashes($row->member_name); ?>">
                    </div>
                    <div class="member_id">
                        <h4><?php echo stripslashes($row->member_name); ?> (<?php echo $this->mlm_function->get_network_code($row->network_sponsor_network_id); ?>)</h4>
                        <span><?php echo convert_date($row->member_join_datetime,'id'); ?></span>
                    </div>
                </li>
            <?php
                }
            } else {
                // echo 'Belum ada Pendaftaran.';
            }

            // dummy
            if ($i <= 10) {
                $image_url = $themes_url . '/images/no_photo.png';
                for ($j=$i; $j <= 10; $j++) { 
                    ?>
                        <li>
                            <div class="badge badge-success"><?php echo $j; ?></div>
                            <div class="member_img">
                                <img src="<?php echo $image_url;?>" alt="-">
                            </div>
                            <div class="member_id">
                                <h4>-</h4>
                                <span>-</span>
                            </div>
                        </li>
                    <?php
                }
            }
            ?>
        </ul>
    </div>
</div>

<div class="col-md-3 stats">
    <h4 class="title"><i class="fa fa-users"></i>&nbsp; <strong><a href="<?php echo base_url('reward'); ?>" class="white-to-green">Reward</a></strong></h4>
    <div class="scroll-list-3 scroll-text">
        <ul>
            <?php
            $i=1;
            if ($reward->num_rows() > 0) {
                foreach ($reward->result() as $row) {
                    $detail = $this->mlm_function->get_arr_member_detail($row->network_id); 
                    if(!empty($detail['member_image']) && file_exists(_dir_member . $detail['member_image'])){
                        $image_url = $image_dir . $detail['member_image'];
                    } else {
                        $image_url = $themes_url . '/images/no_photo.png';
                    }
            ?>
                <li>
                    <div class="badge badge-success"><?php echo $i++; ?></div>
                    <div class="member_img">
                        <img src="<?php echo $image_url;?>" alt="<?php echo stripslashes($row->member_name); ?>">
                    </div>
                    <div class="member_id">
                        <h4><?php echo stripslashes($row->member_name); ?> (<?php echo $row->network_code; ?>)</h4>
                        <span><?php echo $row->reward_qualified_reward_bonus; ?></span>
                    </div>
                </li>
            <?php
                }
            } else {
                // echo 'Belum ada Member Qualified.';
            }

            // dummy
            if ($i <= 10) {
                $image_url = $themes_url . '/images/no_photo.png';
                for ($j=$i; $j <= 10; $j++) { 
                    ?>
                        <li>
                            <div class="badge badge-success"><?php echo $j; ?></div>
                            <div class="member_img">
                                <img src="<?php echo $image_url;?>" alt="-">
                            </div>
                            <div class="member_id">
                                <h4>-</h4>
                                <span>-</span>
                            </div>
                        </li>
                    <?php
                }
            }
            ?>
        </ul>
    </div>
</div>