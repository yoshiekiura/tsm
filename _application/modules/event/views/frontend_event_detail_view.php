<?php
if ($query->num_rows() > 0) {
    $row = $query->row();

    if ($row->event_image != '' && file_exists(_dir_event . $row->event_image)) {
        $image_url = base_url() . _dir_event . $row->event_image;
        $event_image = '<a href="' . base_url() . _dir_event . $row->event_image . '" rel="prettyPhoto[gallery01]"  ><img src="' . base_url() . _dir_event . $row->event_image . '" alt="' . $row->event_image . '" title="' . $row->event_title . '" /></a>';
    } else {
        $image_url = $themes_url . '/uploads/news/mekkah.jpg';
        $event_image = '<img src="' . $image_url . '"  class="thumbnail">';
    }
?>
<div class="panel panel-default" id="block-event">
    <?php if (!empty($title)): ?>
    <div class="panel-heading"><h3><?php echo $title ?></h3></div>
    <?php endif ?>
    <div class="panel-body">
        <table class="table table-striped table-bordered table-event">
            <tbody>
                <tr>
                    <td>
                        <h4 class="title"><?php echo $row->event_title; ?></h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="event">
                            <div class="img-event">
                                <div class="img-thumbnail">
                                    <a class="img-effect img-thumbnail takezoom" href="<?php echo $image_url ?>" rel="prettyPhoto[gallery01]" title="<?php echo $row->event_title; ?> ">
                                        <img src="<?php echo $image_url; ?> " alt="<?php echo $row->event_title; ?> ">
                                        <span class="link-detail">
                                            <i class="fa fa-search-plus"></i>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <table class="table table-striped" id="event_info_tbl">
                            <tr>
                                <td width="15%"><label><b>Tempat</b></label></td>
                                <td width="5%"><center>:</center></td>
                                <td width="80%"><?php echo $row->event_place; ?> </td>
                            </tr>
                            <tr>
                                <td><label><b>Alamat</b></label></td>
                                <td><center>:</center></td>
                                <td><?php echo $row->event_city; ?> </td>
                            </tr>
                            <tr>
                                <td><label><b>Waktu</b></label></td>
                                <td><center>:</center></td>
                                <td><?php echo $row->event_time; ?> </td>
                            </tr>
                            <tr>
                                <td><label><b>HTM</b></label></td>
                                <td><center>:</center></td>
                                <td><?php echo $row->event_ticket; ?> </td>
                            </tr>
                            <tr>
                                <td><label><b>Catatan</b></label></td>
                                <td><center>:</center></td>
                                <td>
                                    <div class="alert alert-warning"><?php echo $row->event_note; ?> </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <table class="table table-striped table-bordered table-event">
            <tr>
                <th>
                    <h4 style="padding: 5px 0">Keterangan</h4>
                </th>
            </tr>
            <tr>
                <td><?php echo $row->event_description; ?> </td>
            </tr>
        </table>
        
        <?php 
        $var = new widget();
        $var->run('widget/frontend_event_random_widget');
        ?>
    </div>
</div>
    <?php
} else {
    echo 'Maaf, Event belum dimuat.';
}
?>