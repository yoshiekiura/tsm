<?php
if (isset($_SESSION['input_message']) && is_serialized($_SESSION['input_message'])) {
    $arr_message = unserialize($_SESSION['input_message']);

    echo $arr_message['message'];
    $_SESSION['input_message'] = array();
}
?>
<?php echo form_open($form_action); ?>
<div style="width: 100%; display: inline-block;">
    <div class="form-group input-group col-md-6" style="padding-left: 0;">
        <?php echo form_hidden('uri_string', uri_string()); ?>
        <?php echo form_input('search_network_code', (isset($this->arr_flashdata['input_search_network_code'])) ? $this->arr_flashdata['input_search_network_code'] : '', 'size="20" placeholder="Pencarian Jaringan Member (Masukkan Kode Member)" class="form-control"'); ?>
        <span class="input-group-btn">
            <button name="search" type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
        </span>
    </div>
</div>
<?php echo form_close(); ?>
<?php
if (!isset($this->arr_flashdata['notfound'])) {
    ?>
    <div class="std">
        <?php echo ($top_network_id > $root_network_id) ? '<a href="' . base_url() . 'voffice/network/geneology/' . $arr_data[1]['upline_network_code'] . '">&laquo; Lihat Jaringan Sebelumnya</a>' : ''; ?>
        <ul id="org" style="display:none">
            <?php
            $sort = 1;
            if ($arr_data[$sort]['geneology_status'] == 'filled') {
                echo '<li class="node-filled" abbr="' . $arr_data[$sort]['network_code'] . '">';
                echo '<div class="node-code"><a href="' . base_url() . 'voffice/network/geneology/' . $arr_data[$sort]['network_code'] . '">' . $arr_data[$sort]['network_code'] . '</a></div>';
                echo '<div class="node-image"><img src="' . $arr_data[$sort]['geneology_image_src'] . '" width="48" height="48" alt="Photo"/></div>';
                echo '<div class="node-name">' . stripslashes($arr_data[$sort]['member_name']) . '</div>';
                echo '<div class="node-name">'. $arr_data[$sort]['total_node_left'] . ' | ' . $arr_data[$sort]['total_node_right'] .'</div>';
                echo '<div class="node-expand"></div>';
            } elseif ($arr_data[$sort]['geneology_status'] == 'empty') {
                echo '<li class="node-empty node-available">';
                echo '<div class="node-clone"><a href="' . base_url() . 'voffice/registration/clone_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">KLONING</a></div>';
                echo '<div class="node-separator"></div>';
                echo '<div class="node-new"><a href="' . base_url() . 'voffice/registration/new_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">PASANG BARU</a></div>';
                echo '<div class="node-expand"></div>';
            } else {
                echo '<li class="node-empty node-available">';
                echo '<div class="node-blank">KOSONG</div>';
                echo '<div class="node-expand"></div>';
            }
            ?>
            <ul>
                <?php
                $sort = 2;
                if ($arr_data[$sort]['geneology_status'] == 'filled') {
                    echo '<li class="node-filled" abbr="' . $arr_data[$sort]['network_code'] . '">';
                    echo '<div class="node-code"><a href="' . base_url() . 'voffice/network/geneology/' . $arr_data[$sort]['network_code'] . '">' . $arr_data[$sort]['network_code'] . '</a></div>';
                    echo '<div class="node-image"><img src="' . $arr_data[$sort]['geneology_image_src'] . '" width="48" height="48" alt="Photo"/></div>';
                    echo '<div class="node-name">' . stripslashes($arr_data[$sort]['member_name']) . '</div>';
                    
                    echo '<div class="node-name">'. $arr_data[$sort]['total_node_left'] . ' | ' . $arr_data[$sort]['total_node_right'] .'</div>';
                    echo '<div class="node-expand"></div>';
                } elseif ($arr_data[$sort]['geneology_status'] == 'empty') {
                    echo '<li class="node-empty node-available">';
                    echo '<div class="node-clone"><a href="' . base_url() . 'voffice/registration/clone_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">KLONING</a></div>';
                    echo '<div class="node-separator"></div>';
                    echo '<div class="node-new"><a href="' . base_url() . 'voffice/registration/new_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">PASANG BARU</a></div>';
                    echo '<div class="node-expand"></div>';
                } else {
                    echo '<li class="node-empty node-available">';
                    echo '<div class="node-blank">KOSONG</div>';
                    echo '<div class="node-expand"></div>';
                }
                ?>
                <ul>
                    <?php
                    $sort = 4;
                    if ($arr_data[$sort]['geneology_status'] == 'filled') {
                        echo '<li class="node-filled" abbr="' . $arr_data[$sort]['network_code'] . '">';
                        echo '<div class="node-code"><a href="' . base_url() . 'voffice/network/geneology/' . $arr_data[$sort]['network_code'] . '">' . $arr_data[$sort]['network_code'] . '</a></div>';
                        echo '<div class="node-image"><img src="' . $arr_data[$sort]['geneology_image_src'] . '" width="48" height="48" alt="Photo"/></div>';
                        echo '<div class="node-name">' . stripslashes($arr_data[$sort]['member_name']) . '</div>';
                        
                        echo '<div class="node-name">'. $arr_data[$sort]['total_node_left'] . ' | ' . $arr_data[$sort]['total_node_right'] .'</div>';
                        echo '<div class="node-expand"></div>';
                    } elseif ($arr_data[$sort]['geneology_status'] == 'empty') {
                        echo '<li class="node-empty node-available">';
                        echo '<div class="node-clone"><a href="' . base_url() . 'voffice/registration/clone_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">KLONING</a></div>';
                        echo '<div class="node-separator"></div>';
                        echo '<div class="node-new"><a href="' . base_url() . 'voffice/registration/new_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">PASANG BARU</a></div>';
                        echo '<div class="node-expand"></div>';
                    } else {
                        echo '<li class="node-empty node-available">';
                        echo '<div class="node-blank">KOSONG</div>';
                        echo '<div class="node-expand"></div>';
                    }
                    ?>
                    <ul>
                        <?php
                        $sort = 8;
                        if ($arr_data[$sort]['geneology_status'] == 'filled') {
                            echo '<li class="node-filled" abbr="' . $arr_data[$sort]['network_code'] . '">';
                            echo '<div class="node-code"><a href="' . base_url() . 'voffice/network/geneology/' . $arr_data[$sort]['network_code'] . '">' . $arr_data[$sort]['network_code'] . '</a></div>';
                            echo '<div class="node-image"><img src="' . $arr_data[$sort]['geneology_image_src'] . '" width="48" height="48" alt="Photo"/></div>';
                            echo '<div class="node-name">' . stripslashes($arr_data[$sort]['member_name']) . '</div>';
                            
                            echo '<div class="node-name">'. $arr_data[$sort]['total_node_left'] . ' | ' . $arr_data[$sort]['total_node_right'] .'</div>';
                            echo '<div class="node-expand"></div>';
                        } elseif ($arr_data[$sort]['geneology_status'] == 'empty') {
                            echo '<li class="node-empty node-available">';
                            echo '<div class="node-clone"><a href="' . base_url() . 'voffice/registration/clone_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">KLONING</a></div>';
                            echo '<div class="node-separator"></div>';
                            echo '<div class="node-new"><a href="' . base_url() . 'voffice/registration/new_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">PASANG BARU</a></div>';
                            echo '<div class="node-expand"></div>';
                        } else {
                            echo '<li class="node-empty node-available">';
                            echo '<div class="node-blank">KOSONG</div>';
                            echo '<div class="node-expand"></div>';
                        }
                        ?>
                        </li>
                        <?php
                        $sort = 9;
                        if ($arr_data[$sort]['geneology_status'] == 'filled') {
                            echo '<li class="node-filled" abbr="' . $arr_data[$sort]['network_code'] . '">';
                            echo '<div class="node-code"><a href="' . base_url() . 'voffice/network/geneology/' . $arr_data[$sort]['network_code'] . '">' . $arr_data[$sort]['network_code'] . '</a></div>';
                            echo '<div class="node-image"><img src="' . $arr_data[$sort]['geneology_image_src'] . '" width="48" height="48" alt="Photo"/></div>';
                            echo '<div class="node-name">' . stripslashes($arr_data[$sort]['member_name']) . '</div>';
                            
                            echo '<div class="node-name">'. $arr_data[$sort]['total_node_left'] . ' | ' . $arr_data[$sort]['total_node_right'] .'</div>';
                            echo '<div class="node-expand"></div>';
                        } elseif ($arr_data[$sort]['geneology_status'] == 'empty') {
                            echo '<li class="node-empty node-available">';
                            echo '<div class="node-clone"><a href="' . base_url() . 'voffice/registration/clone_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">KLONING</a></div>';
                            echo '<div class="node-separator"></div>';
                            echo '<div class="node-new"><a href="' . base_url() . 'voffice/registration/new_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">PASANG BARU</a></div>';
                            echo '<div class="node-expand"></div>';
                        } else {
                            echo '<li class="node-empty node-available">';
                            echo '<div class="node-blank">KOSONG</div>';
                            echo '<div class="node-expand"></div>';
                        }
                        ?>
                        </li>
                    </ul>
                    </li>
                    <?php
                    $sort = 5;
                    if ($arr_data[$sort]['geneology_status'] == 'filled') {
                        echo '<li class="node-filled" abbr="' . $arr_data[$sort]['network_code'] . '">';
                        echo '<div class="node-code"><a href="' . base_url() . 'voffice/network/geneology/' . $arr_data[$sort]['network_code'] . '">' . $arr_data[$sort]['network_code'] . '</a></div>';
                        echo '<div class="node-image"><img src="' . $arr_data[$sort]['geneology_image_src'] . '" width="48" height="48" alt="Photo"/></div>';
                        echo '<div class="node-name">' . stripslashes($arr_data[$sort]['member_name']) . '</div>';
                        
                        echo '<div class="node-name">'. $arr_data[$sort]['total_node_left'] . ' | ' . $arr_data[$sort]['total_node_right'] .'</div>';
                        echo '<div class="node-expand"></div>';
                    } elseif ($arr_data[$sort]['geneology_status'] == 'empty') {
                        echo '<li class="node-empty node-available">';
                        echo '<div class="node-clone"><a href="' . base_url() . 'voffice/registration/clone_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">KLONING</a></div>';
                        echo '<div class="node-separator"></div>';
                        echo '<div class="node-new"><a href="' . base_url() . 'voffice/registration/new_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">PASANG BARU</a></div>';
                        echo '<div class="node-expand"></div>';
                    } else {
                        echo '<li class="node-empty node-available">';
                        echo '<div class="node-blank">KOSONG</div>';
                        echo '<div class="node-expand"></div>';
                    }
                    ?>
                    <ul>
                        <?php
                        $sort = 10;
                        if ($arr_data[$sort]['geneology_status'] == 'filled') {
                            echo '<li class="node-filled" abbr="' . $arr_data[$sort]['network_code'] . '">';
                            echo '<div class="node-code"><a href="' . base_url() . 'voffice/network/geneology/' . $arr_data[$sort]['network_code'] . '">' . $arr_data[$sort]['network_code'] . '</a></div>';
                            echo '<div class="node-image"><img src="' . $arr_data[$sort]['geneology_image_src'] . '" width="48" height="48" alt="Photo"/></div>';
                            echo '<div class="node-name">' . stripslashes($arr_data[$sort]['member_name']) . '</div>';
                            
                            echo '<div class="node-name">'. $arr_data[$sort]['total_node_left'] . ' | ' . $arr_data[$sort]['total_node_right'] .'</div>';
                            echo '<div class="node-expand"></div>';
                        } elseif ($arr_data[$sort]['geneology_status'] == 'empty') {
                            echo '<li class="node-empty node-available">';
                            echo '<div class="node-clone"><a href="' . base_url() . 'voffice/registration/clone_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">KLONING</a></div>';
                            echo '<div class="node-separator"></div>';
                            echo '<div class="node-new"><a href="' . base_url() . 'voffice/registration/new_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">PASANG BARU</a></div>';
                            echo '<div class="node-expand"></div>';
                        } else {
                            echo '<li class="node-empty node-available">';
                            echo '<div class="node-blank">KOSONG</div>';
                            echo '<div class="node-expand"></div>';
                        }
                        ?>
                        </li>
                        <?php
                        $sort = 11;
                        if ($arr_data[$sort]['geneology_status'] == 'filled') {
                            echo '<li class="node-filled" abbr="' . $arr_data[$sort]['network_code'] . '">';
                            echo '<div class="node-code"><a href="' . base_url() . 'voffice/network/geneology/' . $arr_data[$sort]['network_code'] . '">' . $arr_data[$sort]['network_code'] . '</a></div>';
                            echo '<div class="node-image"><img src="' . $arr_data[$sort]['geneology_image_src'] . '" width="48" height="48" alt="Photo"/></div>';
                            echo '<div class="node-name">' . stripslashes($arr_data[$sort]['member_name']) . '</div>';
                            
                            echo '<div class="node-name">'. $arr_data[$sort]['total_node_left'] . ' | ' . $arr_data[$sort]['total_node_right'] .'</div>';
                            echo '<div class="node-expand"></div>';
                        } elseif ($arr_data[$sort]['geneology_status'] == 'empty') {
                            echo '<li class="node-empty node-available">';
                            echo '<div class="node-clone"><a href="' . base_url() . 'voffice/registration/clone_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">KLONING</a></div>';
                            echo '<div class="node-separator"></div>';
                            echo '<div class="node-new"><a href="' . base_url() . 'voffice/registration/new_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">PASANG BARU</a></div>';
                            echo '<div class="node-expand"></div>';
                        } else {
                            echo '<li class="node-empty node-available">';
                            echo '<div class="node-blank">KOSONG</div>';
                            echo '<div class="node-expand"></div>';
                        }
                        ?>
                        </li>
                    </ul>
                    </li>
                </ul>
                </li>
                <?php
                $sort = 3;
                if ($arr_data[$sort]['geneology_status'] == 'filled') {
                    echo '<li class="node-filled" abbr="' . $arr_data[$sort]['network_code'] . '">';
                    echo '<div class="node-code"><a href="' . base_url() . 'voffice/network/geneology/' . $arr_data[$sort]['network_code'] . '">' . $arr_data[$sort]['network_code'] . '</a></div>';
                    echo '<div class="node-image"><img src="' . $arr_data[$sort]['geneology_image_src'] . '" width="48" height="48" alt="Photo"/></div>';
                    echo '<div class="node-name">' . stripslashes($arr_data[$sort]['member_name']) . '</div>';
                    
                    echo '<div class="node-name">'. $arr_data[$sort]['total_node_left'] . ' | ' . $arr_data[$sort]['total_node_right'] .'</div>';
                    echo '<div class="node-expand"></div>';
                } elseif ($arr_data[$sort]['geneology_status'] == 'empty') {
                    echo '<li class="node-empty node-available">';
                    echo '<div class="node-clone"><a href="' . base_url() . 'voffice/registration/clone_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">KLONING</a></div>';
                    echo '<div class="node-separator"></div>';
                    echo '<div class="node-new"><a href="' . base_url() . 'voffice/registration/new_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">PASANG BARU</a></div>';
                    echo '<div class="node-expand"></div>';
                } else {
                    echo '<li class="node-empty node-available">';
                    echo '<div class="node-blank">KOSONG</div>';
                    echo '<div class="node-expand"></div>';
                }
                ?>
                <ul>
                    <?php
                    $sort = 6;
                    if ($arr_data[$sort]['geneology_status'] == 'filled') {
                        echo '<li class="node-filled" abbr="' . $arr_data[$sort]['network_code'] . '">';
                        echo '<div class="node-code"><a href="' . base_url() . 'voffice/network/geneology/' . $arr_data[$sort]['network_code'] . '">' . $arr_data[$sort]['network_code'] . '</a></div>';
                        echo '<div class="node-image"><img src="' . $arr_data[$sort]['geneology_image_src'] . '" width="48" height="48" alt="Photo"/></div>';
                        echo '<div class="node-name">' . stripslashes($arr_data[$sort]['member_name']) . '</div>';
                        
                        echo '<div class="node-name">'. $arr_data[$sort]['total_node_left'] . ' | ' . $arr_data[$sort]['total_node_right'] .'</div>';
                        echo '<div class="node-expand"></div>';
                    } elseif ($arr_data[$sort]['geneology_status'] == 'empty') {
                        echo '<li class="node-empty node-available">';
                        echo '<div class="node-clone"><a href="' . base_url() . 'voffice/registration/clone_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">KLONING</a></div>';
                        echo '<div class="node-separator"></div>';
                        echo '<div class="node-new"><a href="' . base_url() . 'voffice/registration/new_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">PASANG BARU</a></div>';
                        echo '<div class="node-expand"></div>';
                    } else {
                        echo '<li class="node-empty node-available">';
                        echo '<div class="node-blank">KOSONG</div>';
                        echo '<div class="node-expand"></div>';
                    }
                    ?>
                    <ul>
                        <?php
                        $sort = 12;
                        if ($arr_data[$sort]['geneology_status'] == 'filled') {
                            echo '<li class="node-filled" abbr="' . $arr_data[$sort]['network_code'] . '">';
                            echo '<div class="node-code"><a href="' . base_url() . 'voffice/network/geneology/' . $arr_data[$sort]['network_code'] . '">' . $arr_data[$sort]['network_code'] . '</a></div>';
                            echo '<div class="node-image"><img src="' . $arr_data[$sort]['geneology_image_src'] . '" width="48" height="48" alt="Photo"/></div>';
                            echo '<div class="node-name">' . stripslashes($arr_data[$sort]['member_name']) . '</div>';
                            
                            echo '<div class="node-name">'. $arr_data[$sort]['total_node_left'] . ' | ' . $arr_data[$sort]['total_node_right'] .'</div>';
                            echo '<div class="node-expand"></div>';
                        } elseif ($arr_data[$sort]['geneology_status'] == 'empty') {
                            echo '<li class="node-empty node-available">';
                            echo '<div class="node-clone"><a href="' . base_url() . 'voffice/registration/clone_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">KLONING</a></div>';
                            echo '<div class="node-separator"></div>';
                            echo '<div class="node-new"><a href="' . base_url() . 'voffice/registration/new_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">PASANG BARU</a></div>';
                            echo '<div class="node-expand"></div>';
                        } else {
                            echo '<li class="node-empty node-available">';
                            echo '<div class="node-blank">KOSONG</div>';
                            echo '<div class="node-expand"></div>';
                        }
                        ?>
                        </li>
                        <?php
                        $sort = 13;
                        if ($arr_data[$sort]['geneology_status'] == 'filled') {
                            echo '<li class="node-filled" abbr="' . $arr_data[$sort]['network_code'] . '">';
                            echo '<div class="node-code"><a href="' . base_url() . 'voffice/network/geneology/' . $arr_data[$sort]['network_code'] . '">' . $arr_data[$sort]['network_code'] . '</a></div>';
                            echo '<div class="node-image"><img src="' . $arr_data[$sort]['geneology_image_src'] . '" width="48" height="48" alt="Photo"/></div>';
                            echo '<div class="node-name">' . stripslashes($arr_data[$sort]['member_name']) . '</div>';
                            
                            echo '<div class="node-name">'. $arr_data[$sort]['total_node_left'] . ' | ' . $arr_data[$sort]['total_node_right'] .'</div>';
                            echo '<div class="node-expand"></div>';
                        } elseif ($arr_data[$sort]['geneology_status'] == 'empty') {
                            echo '<li class="node-empty node-available">';
                            echo '<div class="node-clone"><a href="' . base_url() . 'voffice/registration/clone_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">KLONING</a></div>';
                            echo '<div class="node-separator"></div>';
                            echo '<div class="node-new"><a href="' . base_url() . 'voffice/registration/new_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">PASANG BARU</a></div>';
                            echo '<div class="node-expand"></div>';
                        } else {
                            echo '<li class="node-empty node-available">';
                            echo '<div class="node-blank">KOSONG</div>';
                            echo '<div class="node-expand"></div>';
                        }
                        ?>
                        </li>
                    </ul>
                    </li>
                    <?php
                    $sort = 7;
                    if ($arr_data[$sort]['geneology_status'] == 'filled') {
                        echo '<li class="node-filled" abbr="' . $arr_data[$sort]['network_code'] . '">';
                        echo '<div class="node-code"><a href="' . base_url() . 'voffice/network/geneology/' . $arr_data[$sort]['network_code'] . '">' . $arr_data[$sort]['network_code'] . '</a></div>';
                        echo '<div class="node-image"><img src="' . $arr_data[$sort]['geneology_image_src'] . '" width="48" height="48" alt="Photo"/></div>';
                        echo '<div class="node-name">' . stripslashes($arr_data[$sort]['member_name']) . '</div>';
                        
                        echo '<div class="node-name">'. $arr_data[$sort]['total_node_left'] . ' | ' . $arr_data[$sort]['total_node_right'] .'</div>';
                        echo '<div class="node-expand"></div>';
                    } elseif ($arr_data[$sort]['geneology_status'] == 'empty') {
                        echo '<li class="node-empty node-available">';
                        echo '<div class="node-clone"><a href="' . base_url() . 'voffice/registration/clone_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">KLONING</a></div>';
                        echo '<div class="node-separator"></div>';
                        echo '<div class="node-new"><a href="' . base_url() . 'voffice/registration/new_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">PASANG BARU</a></div>';
                        echo '<div class="node-expand"></div>';
                    } else {
                        echo '<li class="node-empty node-available">';
                        echo '<div class="node-blank">KOSONG</div>';
                        echo '<div class="node-expand"></div>';
                    }
                    ?>
                    <ul>
                        <?php
                        $sort = 14;
                        if ($arr_data[$sort]['geneology_status'] == 'filled') {
                            echo '<li class="node-filled" abbr="' . $arr_data[$sort]['network_code'] . '">';
                            echo '<div class="node-code"><a href="' . base_url() . 'voffice/network/geneology/' . $arr_data[$sort]['network_code'] . '">' . $arr_data[$sort]['network_code'] . '</a></div>';
                            echo '<div class="node-image"><img src="' . $arr_data[$sort]['geneology_image_src'] . '" width="48" height="48" alt="Photo"/></div>';
                            echo '<div class="node-name">' . stripslashes($arr_data[$sort]['member_name']) . '</div>';
                            
                            echo '<div class="node-name">'. $arr_data[$sort]['total_node_left'] . ' | ' . $arr_data[$sort]['total_node_right'] .'</div>';
                            echo '<div class="node-expand"></div>';
                        } elseif ($arr_data[$sort]['geneology_status'] == 'empty') {
                            echo '<li class="node-empty node-available">';
                            echo '<div class="node-clone"><a href="' . base_url() . 'voffice/registration/clone_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">KLONING</a></div>';
                            echo '<div class="node-separator"></div>';
                            echo '<div class="node-new"><a href="' . base_url() . 'voffice/registration/new_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">PASANG BARU</a></div>';
                            echo '<div class="node-expand"></div>';
                        } else {
                            echo '<li class="node-empty node-available">';
                            echo '<div class="node-blank">KOSONG</div>';
                            echo '<div class="node-expand"></div>';
                        }
                        ?>
                        </li>
                        <?php
                        $sort = 15;
                        if ($arr_data[$sort]['geneology_status'] == 'filled') {
                            echo '<li class="node-filled" abbr="' . $arr_data[$sort]['network_code'] . '">';
                            echo '<div class="node-code"><a href="' . base_url() . 'voffice/network/geneology/' . $arr_data[$sort]['network_code'] . '">' . $arr_data[$sort]['network_code'] . '</a></div>';
                            echo '<div class="node-image"><img src="' . $arr_data[$sort]['geneology_image_src'] . '" width="48" height="48" alt="Photo"/></div>';
                            echo '<div class="node-name">' . stripslashes($arr_data[$sort]['member_name']) . '</div>';
                            
                            echo '<div class="node-name">'. $arr_data[$sort]['total_node_left'] . ' | ' . $arr_data[$sort]['total_node_right'] .'</div>';
                            echo '<div class="node-expand"></div>';
                        } elseif ($arr_data[$sort]['geneology_status'] == 'empty') {
                            echo '<li class="node-empty node-available">';
                            echo '<div class="node-clone"><a href="' . base_url() . 'voffice/registration/clone_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">KLONING</a></div>';
                            echo '<div class="node-separator"></div>';
                            echo '<div class="node-new"><a href="' . base_url() . 'voffice/registration/new_reg/' . base64_encode($arr_data[$sort]['geneology_upline_network_code']) . '/' . base64_encode($arr_data[$sort]['geneology_node_position']) . '">PASANG BARU</a></div>';
                            echo '<div class="node-expand"></div>';
                        } else {
                            echo '<li class="node-empty node-available">';
                            echo '<div class="node-blank">KOSONG</div>';
                            echo '<div class="node-expand"></div>';
                        }
                        ?>
                        </li>
                    </ul>
                    </li>
                </ul>
                </li>
            </ul>
            </li>
        </ul>

        <div id="chart" class="orgChart reset-box-sizing"></div>

    </div>
    <script>
        $(document).ready(function () {

            $("#org").jOrgChart({
                chartElement: '#chart', //default: 'body'
                dragAndDrop: false, //default: false
                depth: -1, // default: -1
                chartClass: 'jOrgChart', //default: 'jOrgChart'
                expandable: true //default: true
            });

            $('.node-filled').each(function () {
                var network_code = $(this).attr('abbr');
                $(this).qtip({
                    content: {
                        text: function (event, api) {
                            $.ajax({
                                url: '<?php echo base_url(); ?>voffice/network/get_member_info/' + network_code
                            })
                                    .then(function (content) {
                                        api.set('content.text', content);
                                    }, function (xhr, status, error) {
                                        api.set('content.text', status + ': ' + error);
                                    });
                            return 'Loading...';
                        }
                    },
                    position: {
                        my: 'center left',
                        at: 'center right',
                        viewport: $(window)
                    },
                    show: {
                        event: 'click mouseenter'
                    },
                    hide: {
                        event: 'click mouseleave'
                    },
                    style: 'qtip-wiki'
                });
            });

        });
    </script>
    <?php
}
?>