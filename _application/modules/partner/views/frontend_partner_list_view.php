<!--<div class="col-md-9" id="main-side">-->
    <!--<div class="panel panel-default">-->
        <div class="panel-heading">&nbsp;</div>
        <div class="panel-body">
            <div id="block-news-list">
                <ul class="list">
                    <?php
            $i = 1;
            if ($query->num_rows() > 0) {

                echo '<div class="row-fluid">';

                foreach ($query->result() as $row) {
                    
                    if ($row->partner_image != '' && file_exists(_dir_partner . $row->partner_image)) {
                        $partner_image = '<img src="' . base_url() . 'media/' . _dir_partner . '250/250/' . $row->partner_image . '" alt="' . $row->partner_image . '" title="' . $row->partner_title . '">';
                    } else
                        $partner_image = '';
                    
                    echo '<li>
                        <div class="row">
                            <div class="col-md-2">
                                <span class="date">
                                    <i class="glyphicon glyphicon-calendar"></i>
                                    <small>'. $row->partner_input_date . '</small>
                                    <strong>05</strong>
                                </span>
                            </div>
                            <div class="col-md-3 no-both">
                                <a href="#" class="thumbnail">
                                    ' . $partner_image . '
                                </a>
                            </div>
                            <div class="col-md-7">
                                <div class="description">
                                    <h4><a href="' . base_url() . 'partner/detail/' . $row->partner_id . '/' . url_title($row->partner_title) . '">' . $row->partner_title . ' </a></h4>
                                    <p style="color: #666; margin-bottom: 15px;">
                                        ' . $row->partner_short_content . '
                                    </p>
                                    <p>
                                       <a href="' . base_url() . 'partner/detail/' . $row->partner_id . '/' . url_title($row->partner_title) . '" class="btn btn-default btn-sm">Selengkapnya &nbsp;&raquo;</a>
                                        <small class="pull-right"><i class="glyphicon glyphicon-time"></i>&nbsp; dipost : ' . $row->partner_input_date . '</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </li>';
                    
                }
                if ($i % 3 == 0)
                    echo '</div><hr><br>';
            } else {
                echo 'Maaf, Partner belum dimuat.';
            }
            ?>
                   
                </ul>

                <ul class="pagination">
                    <li><?php echo $pagination; ?></li>
                    
                </ul>
            </div>
        </div>
    <!--</div>-->

<!--</div>-->
									