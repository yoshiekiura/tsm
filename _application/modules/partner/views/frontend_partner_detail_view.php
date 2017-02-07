<?php
if ($query->num_rows() > 0) {
    $row = $query->row();

    if ($row->partner_image != '' && file_exists(_dir_partner . $row->partner_image)) {
        $partner_image = '<a href="' . base_url() . _dir_partner . $row->partner_image . '" target="_blank"><img src="' . base_url() . 'media/' . _dir_partner . '520/520/' . $row->partner_image . '" alt="' . $row->partner_image . '" title="' . $row->partner_title . '" /></a>';
    } else {
        $partner_image = '';
    }
    ?>
    <div class="panel-body">
                <h2 class="title"><?php echo $row->partner_title; ?></h2>
                <br>
                <span><i class="fa fa-calendar"></i>&nbsp;<small><?php echo convert_date($row->partner_input_datetime,'id');?></small>&nbsp;</span> | &nbsp; 
                <span><i class="fa fa-gear"></i>&nbsp; <small><a href="<?php echo base_url(); ?>partner">Partner</a></small>&nbsp;</span> | &nbsp; 
                <hr>
                <p style="text-align: left; color: #333;">
                    <?php echo $row->partner_content; ?>
                </p>

                <br>
                <?php echo $partner_image; ?>
                <br><br>
                <br>
        <?php
    } else {
        echo 'Maaf, Partner belum dimuat.';
    }
    ?>
</div>



