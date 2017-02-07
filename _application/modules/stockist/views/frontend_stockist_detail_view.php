<?php
if ($query->num_rows() > 0) {
    $row = $query->row();

    if ($row->stockist_image != '' && file_exists(_dir_stockist . $row->stockist_image)) {
        $stockist_image = '<a href="' . base_url() . _dir_stockist . $row->stockist_image . '" target="_blank"><img src="' . base_url() . 'media/' . _dir_stockist . '520/520/' . $row->stockist_image . '" alt="' . $row->stockist_image . '" title="' . $row->stockist_title . '" /></a>';
    } else {
        $stockist_image = '';
    }
    ?>
    <div class="panel-body">
        <h2 class="title"><?php echo $row->stockist_title; ?></h2>
        <br>
        <span><i class="fa fa-calendar"></i>&nbsp;<small><?php echo convert_datetime($row->stockist_input_datetime,'id');?></small>&nbsp;</span> | &nbsp; 
        <span><i class="fa fa-clock-o"></i>&nbsp; <small>16.02 WIB</small>&nbsp;</span> | &nbsp; 
        <span><i class="fa fa-gear"></i>&nbsp; <small><a href="<?php echo base_url(); ?>stockist">Berita</a></small>&nbsp;</span> | &nbsp; 
        <hr>
        <p style="text-align: left; color: #333;">
            <?php echo $row->stockist_content; ?>
        </p>

        <br>
        <?php echo $stockist_image; ?>
        <br><br>
        <br>
        <?php
    } else {
        echo 'Maaf, berita belum dimuat.';
    }
    ?>
</div>



