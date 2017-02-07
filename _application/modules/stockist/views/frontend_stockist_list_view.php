<!--<div class="col-md-9" id="main-side">-->
<!--<div class="panel panel-default">-->
<div class="panel-body">
    <div id="block-news-list">

        <?php
        $i = 1;
        if ($query->num_rows() > 0) {

            echo '<div class="row-fluid">

                    <h3 class="title">Daftar Stokis di seluruh Indonesia :</h3>

                        <table class="table table-striped table-hovered" style="font-size: 12px;">
                            <tr class="silverbg">
                                <th width="50%" colspan="2">Nama Outlet</th>
                                <th width="50%">Lokasi</th>
                            </tr>';
            foreach ($query->result() as $row) {

                if ($row->stockist_image != '' && file_exists(_dir_stockist . $row->stockist_image)) {
                    $stockist_image = '<img src="' . base_url() . _dir_stockist . $row->stockist_image . '" style="width: 95%; border: #2a3333 3px solid;">';
                } else
                    $stockist_image = '<img src="' . base_url() . _dir_stockist . 'no_image.png' . '" style="width: 95%; border: #2a3333 3px solid;">';
                echo ' 
                            <tr>
                                <td width="20%">
                                '.$stockist_image.'
                                </td>
                                <td width="30%"><strong>Outlet Pusat</strong></td>
                                <td>
                                    '.$row->stockist_place.'<br><br>

                                    <i class="glyphicon glyphicon-phone-alt"></i>&nbsp; '.$row->stockist_phone.'<br>
                                    <i class="glyphicon glyphicon-dashboard"></i>&nbsp; '.$row->stockist_time.'
                                </td>
                                
                            </tr>';
            }
            if ($i % 3 == 0)
                echo '</div><hr><br>';
        } else {
            echo 'Maaf, berita belum dimuat.';
        }
        ?>

        </table>
    </div>

    <ul class="pagination">
        <li><?php echo $pagination; ?></li>

    </ul>

</div>





<!--</div>-->

<!--</div>-->
