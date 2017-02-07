<?php
if ($query->num_rows() > 0) {
    $row = $query->row();

    if ($row->promo_image != '' && file_exists(_dir_promo . $row->promo_image)) {
        $promo_image = '<a href="' . base_url() . _dir_promo . $row->promo_image . '" target="_blank"><img src="' . base_url() . 'media/' . _dir_promo . '520/520/' . $row->promo_image . '" alt="' . $row->promo_image . '" title="' . $row->promo_title . '" /></a>';
    } else {
        $promo_image = '';
    }
    ?>
    <div class="panel-body">
        <h3 class="title"><?php echo $row->promo_title; ?></h3>
                        <br>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo $promo_image; ?>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-striped table-promo">
                                    <tr>
                                        <td width="30%"><label class="fa fa-calendar"></label>&nbsp; Post </td>
                                        <td><?php echo convert_date($row->promo_input_datetime,'id');?></td>
                                    </tr>
                                    <tr>
                                        <td><label class="fa fa-cog"></label>&nbsp; Kategori </td>
                                        <td><a href="<?php echo base_url();?>promo">Promo</a></td>
                                    </tr>
                                    <tr>
                                        <td><label class="fa fa-tags"></label>&nbsp; Price </td>
                                        <td><div class="pricing"><sup>Rp</sup> <?php echo  number_format($row->promo_price); ?></div></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <p style="text-align: left; color: #333;"><?php echo $row->promo_content; ?></p>
                        <br>
        <?php
    } else {
        echo 'Maaf, Promo belum dimuat.';
    }
    ?>
</div>


                        
                    

