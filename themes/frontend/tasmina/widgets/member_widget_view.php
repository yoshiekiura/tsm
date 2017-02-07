<div class="col-md-4 stats">
    <h4 class="title"><i class="fa fa-users"></i>&nbsp; Member<strong> Baru</strong></h4>
    <div class="scroll-list-2 scroll-text">
        <ul>
            <?php
            if ($query->num_rows() > 0) {
                $i=1;
                foreach ($query->result() as $row) {
                 
            ?>
                <li>
                    <div class="badge badge-success"><?php echo $i++; ?></div>
                    <div class="member_img">
                        <img src="<?php echo $themes_url;?>/images/member.jpg" alt="<?php echo $row->member_name; ?>">
                    </div>
                    <div class="member_id">
                        <h4><?php echo $row->member_name; ?></h4>
                        <!-- <p class="title"><?php echo $row->network_code; ?></p> -->
                        <span><?php echo convert_date($row->member_join_datetime,'id'); ?></span>
                    </div>
                </li>
            <?php
                }
            } else {
                echo 'Belum ada Pendaftaran.';
            }
            ?>
        </ul>
    </div>
</div>

<div class="col-md-4 stats">
    <h4 class="title"><i class="fa fa-users"></i>&nbsp; Top<strong> Income</strong></h4>
    <div class="scroll-list-3 scroll-text">
        <ul>
            <?php
            if ($top_income->num_rows() > 0) {
                $i=1;
                foreach ($top_income->result() as $row) {
                 
            ?>
                <li>
                    <div class="badge badge-success"><?php echo $i++; ?></div>
                    <div class="member_img">
                        <img src="<?php echo $themes_url;?>/images/member.jpg" alt="<?php echo $row->member_name; ?>">
                    </div>
                    <div class="member_id">
                        <h4><?php echo $row->member_name; ?> (<?php echo $row->network_code; ?>)</h4>
                        <span><?php echo $this->function_lib->set_number_format($row->total_bonus); ?></span>
                    </div>
                </li>
            <?php
                }
            } else {
                echo 'Belum ada Pendaftaran.';
            }
            ?>
        </ul>
    </div>
</div>
<div class="col-md-4 stats">
    <h4 class="title"><i class="fa fa-users"></i>&nbsp; Top<strong> Sponsor</strong></h4>
    <div class="scroll-list-3 scroll-text">
        <ul>
            <?php
            if ($top_sponsor->num_rows() > 0) {
                $i=1;
                foreach ($top_sponsor->result() as $row) {
                 
            ?>
                <li>
                    <div class="badge badge-success"><?php echo $i++; ?></div>
                    <div class="member_img">
                        <img src="<?php echo $themes_url;?>/images/member.jpg" alt="<?php echo $row->member_name; ?>">
                    </div>
                    <div class="member_id">
                        <h4><?php echo $row->member_name; ?></h4>
                        <span><?php echo convert_date($row->member_join_datetime,'id'); ?></span>
                    </div>
                </li>
            <?php
                }
            } else {
                echo 'Belum ada Pendaftaran.';
            }
            ?>
        </ul>
    </div>
</div>