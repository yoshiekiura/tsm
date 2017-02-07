<!DOCTYPE html>

<!-- 
Template Name: Omember - OmarKenthir - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.0
Version: 1.0
Author: @myrindaman
Website: http://www.netsolmind.com/
Email: designer@esoftdream.net
-->

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->

    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title>Virtual Office -  <?php echo $this->site_configuration['title']; ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <meta name="MobileOptimized" content="320">

        <!-- BEGIN GLOBAL MANDATORY STYLES -->          
        <link type="text/css" rel="stylesheet" href="<?php echo $themes_url; ?>/css/font-awesome.min.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo $themes_url; ?>/css/bootstrap.css" />
        <!-- END GLOBAL MANDATORY STYLES -->

        <!-- BEGIN THEME STYLES --> 
        <link type="text/css" rel="stylesheet" href="<?php echo $themes_url; ?>/css/jquery-ui.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo $themes_url; ?>/css/jquery.ui.theme.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo $themes_url; ?>/css/custom.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo $themes_url; ?>/css/style-responsive.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo $themes_url; ?>/css/table.css" />
        <!-- END THEME STYLES -->

        <link rel="shortcut icon" href="<?php echo $themes_url; ?>/images/favicon.ico" />
        
        <!-- LOAD JAVASCRIPT LIBRARY -->
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/jquery-1.9.0.min.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/bootstrap.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/twitter-bootstrap-hover-dropdown.min.js"></script>

        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/jquery.slimscroll.min.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/jquery.blockui.min.js"></script>  
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/jquery.cookie.min.js"></script>
        <!--<script type="text/javascript" src="<?php echo $themes_url; ?>/js/jquery.uniform.min.js"></script>-->
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/script.js"></script>	
        
        <!-- flexigrid starts here -->
        <script type="text/javascript" src="<?php echo base_url(); ?>addons/flexigrid/js/flexigrid.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>addons/flexigrid/js/json2.js"></script>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>addons/flexigrid/css/flexigrid.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>addons/flexigrid/button/style.css" />
        <!-- flexigrid ends here -->
        
        <script type="text/javascript" src="<?php echo base_url(); ?>addons/js/checkbox.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>addons/js/accounting.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>addons/js/accounting.function.js"></script>
        
        <?php
        if(isset($extra_head_content)) {
            echo $extra_head_content;
        }
        ?>
        
    </head>
    <!-- END HEAD -->

    <body class="page-header-fixed">
        <?php
        //profile image
        if ($this->session->userdata('member_detail_image') != '' && file_exists(_dir_member . $this->session->userdata('member_detail_image'))) {
            $profile_image = $this->session->userdata('member_detail_image');
        } else {
            $profile_image = '_default.jpg';
        }
        
        $par_menu = array();
        $sub_menu = array();
        $sort_id = 1;
        
//        $par_menu[$sort_id] = array('title' => 'Alih Pengguna', 'description' => '', 'link' => '#', 'class' => 'icon-refresh');
//        $arr_member_group = $this->session->userdata('arr_member_group');
//        if(is_array($arr_member_group)) {
//            foreach($arr_member_group as $member_group_network_id => $member_group_network_code) {
//                if($member_group_network_id == $this->session->userdata('network_id')) {
//                    $member_group_network_code_label = '<i class="icon-star"></i> ' . $member_group_network_code;
//                } else {
//                    $member_group_network_code_label = '<i class="icon-star-empty"></i> ' . $member_group_network_code;
//                }
//                
//                if($member_group_network_id == $this->session->userdata('parent_group_network_id')) {
//                    $member_group_network_code_label .= ' (Master)';
//                }
//                $sub_menu[$sort_id][] = array('title' => $member_group_network_code_label, 'description' => '', 'link' => 'voffice/systems/switch_user/' . $member_group_network_code);
//            }
//        }
        
        $is_child = $this->function_lib->get_one('sys_network_group', 'network_group_member_network_id', "network_group_member_network_id = '" . $this->session->userdata('network_id') . "'");
        if($is_child == '') {
            $sub_menu[$sort_id][] = array('title' => 'Kelola Anggota Grup', 'description' => '', 'link' => 'voffice/systems/network_group_show');
        }
        
        if(empty($sub_menu[$sort_id]) || count($sub_menu[$sort_id]) <= 0) {
            unset($par_menu[$sort_id]);
        } else {
            $sort_id++;
        }
        
        $par_menu[$sort_id] = array('title' => 'Jaringan', 'description' => '', 'link' => '#', 'class' => 'icon-sitemap');
        $sub_menu[$sort_id] = array(
            array('title' => 'Status Jaringan', 'description' => '', 'link' => 'voffice/network/show'),
            array('title' => 'Geneologi', 'description' => '', 'link' => 'voffice/network/geneology'),
            array('title' => 'Data Downline', 'description' => '', 'link' => 'voffice/network/node'),
            array('title' => 'Data Sponsorisasi', 'description' => '', 'link' => 'voffice/network/sponsoring'),
            array('title' => 'History Pasangan', 'description' => '', 'link' => 'voffice/network/match'),
            array('title' => 'History Generasi Titik', 'description' => '', 'link' => 'voffice/network/gen_node'),
            array('title' => 'History Generasi Sponsor', 'description' => '', 'link' => 'voffice/network/gen_sponsor'),
            array('title' => 'History Generasi Pasangan', 'description' => '', 'link' => 'voffice/network/gen_match'),
            array('title' => 'History Upline Sponsor', 'description' => '', 'link' => 'voffice/network/upline_sponsor'),
            array('title' => 'History Upline Pasangan', 'description' => '', 'link' => 'voffice/network/upline_match'),
        );
        $sort_id++;
        
        $par_menu[$sort_id] = array('title' => 'Komisi', 'description' => '', 'link' => '#', 'class' => 'icon-gift');
        $sub_menu[$sort_id] = array(
            array('title' => 'Status Komisi', 'description' => '', 'link' => 'voffice/bonus/show'),
            array('title' => 'History Komisi', 'description' => '', 'link' => 'voffice/bonus/log'),
            array('title' => 'History Transfer', 'description' => '', 'link' => 'voffice/bonus/transfer'),
        );
        $sort_id++;
        
        $par_menu[$sort_id] = array('title' => 'Informasi', 'description' => '', 'link' => 'voffice/dashboard/information', 'class' => 'icon-info-sign');
        $sort_id++;

        $par_menu[$sort_id] = array('title' => 'Transfer Ewallet', 'description' => '', 'link' => 'voffice/transfer_ewallet', 'class' => 'icon-info-sign');
        $sort_id++;
        
        $generate_menu = '';
        $generate_menu .= '<ul class="page-sidebar-menu">';
        $generate_menu .= '
            <li>
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler"></div>
                <div class="clearfix"></div>
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            </li>
            <li class="start active ">
                <a href="' . base_url() . 'voffice/dashboard/show">
                    <i class="icon-home"></i> 
                    <span class="title">Dashboard</span>
                    <span class="selected"></span>
                </a>
            </li>
        ';

        // cari root menu
        if (is_array($par_menu)) {

            // ekstrak root menu
            foreach ($par_menu as $rootmenu_sort => $rootmenu_value) {
                if(array_key_exists($rootmenu_sort, $sub_menu)) {
                    $rootmenu_link = 'javascript:;';
                } else {
                    if($rootmenu_value['link'] == '#') {
                        $rootmenu_link = '#';
                    } else {
                        $rootmenu_link = base_url() . $rootmenu_value['link'];
                    }
                }
                $generate_menu .= '
                    <li class="" title="' . $rootmenu_value['description'] . '">
                        <a href="' . $rootmenu_link . '">
                            <i class="' . $rootmenu_value['class'] . '"></i> 
                            <span class="title">' . $rootmenu_value['title'] . '</span>
                ';

                // cari submenu 1
                if(array_key_exists($rootmenu_sort, $sub_menu)) {
                    $generate_menu .= '<span class="arrow"></span>';
                    $generate_menu .= '</a>';
                    $generate_menu .= '<ul class="sub-menu" style="display: none;">';

                    // ekstrak submenu 1 yang par_id adalah menu_id dari root menu
                    foreach ($sub_menu[$rootmenu_sort] as $submenu_1_sort => $submenu_1_value) {
                        if($submenu_1_value['link'] == '#') {
                            $submenu_1_link = '#';
                        } else {
                            $submenu_1_link = base_url() . $submenu_1_value['link'];
                        }
                        
                        $generate_menu .= '<li title="' . $submenu_1_value['description'] . '"><a href="' . $submenu_1_link . '">' . $submenu_1_value['title'] . '</a></li>';
                    }
                    $generate_menu .= '</ul>';
                } else {
                    $generate_menu .= '</a>';
                }
                $generate_menu .= '</li>';
            }
            $generate_menu .= '
                <li class="last">
                    <a href="' . base_url() . 'voffice/logout">
                        <i class="icon-signout"></i> 
                        <span class="title">Log Out</span>
                    </a>
                </li>
            ';
            $generate_menu .= '</ul>';
        }
        ?>
        <div class="header navbar navbar-inverse navbar-fixed-top">
            <!-- BEGIN TOP NAVIGATION BAR -->
            <div class="header-inner">
                <!-- PAGE INFO -->  
                <span class="info-brand"><?php echo $this->site_configuration['title']; ?></span>

                <!-- BEGIN LOGO -->  
                <a class="navbar-brand" href="<?php echo base_url(); ?>voffice/dashboard/show">
                    <img src="<?php echo $themes_url; ?>/images/logo.png" alt="logo" class="img-responsive">
                </a>
                <!-- END LOGO -->

                <!-- BEGIN RESPONSIVE MENU TOGGLER --> 
                <a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <img src="<?php echo $themes_url; ?>/images/menu-toggler.png" alt="">
                </a> 
                <!-- END RESPONSIVE MENU TOGGLER -->

                <!-- BEGIN TOP NAVIGATION MENU -->
                <ul class="nav navbar-nav pull-right">
                    <li><h5 class="li-titles">VIRTUAL OFFICE - <?php echo $this->site_configuration['appname']; ?></h5></li>
                    <li class="devider">&nbsp;</li>

                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <li class="dropdown user">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <img alt="" src="<?php echo base_url() . 'media/' . _dir_member . '30/30/' . $profile_image; ?>">
                            <span class="username"><?php echo $this->session->userdata('member_name'); ?><span class="notification_count_total"></span></span>
                            <i class="icon-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url() . 'voffice/systems/profile'; ?>"><i class="icon-user"></i> Profil</a></li>
                            <li><a href="<?php echo base_url() . 'voffice/systems/password'; ?>"><i class="icon-lock"></i> Ubah Password</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url() . 'voffice/message/show'; ?>"><i class="icon-envelope"></i> Pesan<span id="message_unread_count" class="notification_count"></span></a></li>
                            <li><a href="<?php echo base_url() . 'voffice/testimony/show'; ?>"><i class="icon-comment"></i> Testimoni</a></li>
                            <li><a href="<?php echo base_url() . 'voffice/downloads/show'; ?>"><i class="icon-download-alt"></i> Download File</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url(); ?>voffice/logout"><i class="icon-key"></i> Log Out</a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->

                </ul>
                <!-- END TOP NAVIGATION MENU -->

            </div>
            <!-- END TOP NAVIGATION BAR -->
        </div>

        <div class="clearfix"></div>

        <!-- CONTAINER -->
        <div class="page-container">
            <!-- SIDEBAR MENU -->
            <div class="page-sidebar navbar-collapse collapse" style="">
                <!-- BEGIN SIDEBAR MENU -->
                <?php echo $generate_menu; ?>
                <!-- END SIDEBAR MENU -->
            </div>

            <!-- MAIN CONTAINER -->
            <div class="page-content">            
                <ul class="breadcrumb">
                    <li><a href="<?php echo base_url(); ?>voffice/dashboard/show"><i class="icon-home"></i>&nbsp; Dashboard</a></li>
                    <?php
                    if(isset($arr_breadcrumbs)) {
                        if(is_array($arr_breadcrumbs)) {
                            $i = 1;
                            foreach($arr_breadcrumbs as $breadcrumbs_title => $breadcrumbs_links) {
                                if($breadcrumbs_links != '#') {
                                    $breadcrumbs_links = base_url() . $breadcrumbs_links;
                                }
                                if($i == count($arr_breadcrumbs)) {
                                    echo '<li class="active">' . $breadcrumbs_title . '</li>';
                                } else {
                                    echo '<li><a href="' . $breadcrumbs_links . '">' . $breadcrumbs_title . '</a></li>';
                                }
                                $i++;
                            }
                        }
                    }
                    ?>
                </ul>
                <?php
                if (isset($this->arr_flashdata['confirmation'])) {
                    echo $this->arr_flashdata['confirmation'];
                }
                ?>
                <?php $this->load->view($contents); ?>
            </div>
            <!-- END MAIN CONTAINER -->
        </div>
        <!-- END CONTAINER -->

        <script>
            jQuery(document).ready(function() {    
                App.init(); // initlayout and core plugins
            });
        </script>
        <!-- END JAVASCRIPTS -->


        <script type="text/javascript">
            $(function(){
                $('.slimScrollDiv').slimScroll({
                    //height: '250px'
                });
            });
        </script>

        <script>
            $(function() {
                $("#datepicker").datepicker();
            });
            
<?php
//ambil data dari method di Member_Controller.php
//(sengaja pakai tag php agar tidak muncul di view source) :D
?>
            function refresh_message_unread_count() {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>voffice/message/get_message_unread_count',
                    dataType: 'json',
                    success: function(response) {
                        if(response['count'] != '') {
                            var count = response['count'];
                            if(parseInt(count) > 0) {
                                $("#message_unread_count").html('&nbsp;<span class="badge badge-alert">' + count + '</span>');
                            } else {
                                $("#message_unread_count").html('');
                            }
                            refresh_total_notification();
                        }
                    }
                });
            }
            
            function refresh_total_notification() {
                if($(".notification_count span").length > 0) {
                    var total_count = 0;
                    $(".notification_count span").each(function() {
                        var count = parseInt($(this).html());
                        total_count += count;
                    });
                    if(total_count > 0) {
                        $(".notification_count_total").html('&nbsp;<span class="badge badge-alert">' + total_count + '</span>');
                    } else {
                        $(".notification_count_total").html('');
                    }
                }
            }
            
            $(document).ready(function() {
                refresh_message_unread_count();
                setInterval(function() {
                    refresh_message_unread_count();
                }, 30000);
                $.ajaxSetup({ cache: false });
            });
        </script>
        
        <?php
        if(isset($extra_foot_content)) {
            echo $extra_foot_content;
        }
        ?>
    </body>
</html>
