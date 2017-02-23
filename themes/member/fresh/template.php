<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $this->site_configuration['title']; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="<?php echo $themes_url; ?>/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo $themes_url; ?>/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?php echo $themes_url; ?>/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo $themes_url; ?>/dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo $themes_url; ?>/dist/css/skins/_all-skins.min.css">
        <!-- bxslider -->
        <link rel="stylesheet" href="<?php echo $themes_url; ?>/plugins/bxslider/jquery.bxslider.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo $themes_url; ?>/plugins/iCheck/flat/blue.css">
        <!-- Morris chart -->
        <link rel="stylesheet" href="<?php echo $themes_url; ?>/plugins/morris/morris.css">
        <!-- jvectormap -->
        <link rel="stylesheet" href="<?php echo $themes_url; ?>/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
        <!-- Date Picker -->
        <link rel="stylesheet" href="<?php echo $themes_url; ?>/plugins/datepicker/datepicker3.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="<?php echo $themes_url; ?>/plugins/daterangepicker/daterangepicker-bs3.css">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="<?php echo $themes_url; ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
        <!-- custom style -->
        <link rel="stylesheet" href="<?php echo $themes_url; ?>/css/custom.css">
        <link rel="stylesheet" href="<?php echo $themes_url; ?>/css/responsive.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <link rel="shortcut icon" href="<?php echo $themes_url; ?>/images/favicon.ico" />
        
        <!-- jQuery 2.2.0 -->
        <script src="<?php echo $themes_url; ?>/plugins/jQuery/jQuery-2.2.0.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="<?php echo $themes_url; ?>/plugins/jQueryUI/jquery-ui.min.js"></script>
        
        <!-- flexigrid starts here -->
        <script type="text/javascript" src="<?php echo base_url(); ?>addons/flexigrid/js/flexigrid.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>addons/flexigrid/js/json2.js"></script>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>addons/flexigrid/css/flexigrid.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>addons/flexigrid/button/style.css" />
        <!-- flexigrid ends here -->
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/script.js"></script>	
        <script type="text/javascript" src="<?php echo base_url(); ?>addons/js/checkbox.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>addons/js/accounting.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>addons/js/accounting.function.js"></script>
        
        <?php
        if(isset($extra_head_content)) {
            echo $extra_head_content;
        }
        ?>
        
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
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
        
        $par_menu[$sort_id] = array('title' => 'Jaringan', 'description' => '', 'link' => '#', 'class' => 'fa fa-sitemap');
        $sub_menu[$sort_id] = array(
            //array('title' => 'Status Jaringan', 'description' => '', 'link' => 'voffice/network/show'),
            array('title' => 'Geneologi', 'description' => '', 'link' => 'voffice/network/geneology'),
            array('title' => 'Geneologi (Tree)', 'description' => '', 'link' => 'voffice/network/geneology_tree'),
            array('title' => 'Data Downline', 'description' => '', 'link' => 'voffice/network/node'),
            array('title' => 'Data Sponsorisasi', 'description' => '', 'link' => 'voffice/network/sponsoring'),
            //array('title' => 'History Pasangan', 'description' => '', 'link' => 'voffice/network/match'),
            //array('title' => 'History Generasi Titik', 'description' => '', 'link' => 'voffice/network/gen_node'),
            // array('title' => 'History Generasi Sponsor', 'description' => '', 'link' => 'voffice/network/gen_sponsor'),
            //array('title' => 'History Generasi Pasangan', 'description' => '', 'link' => 'voffice/network/gen_match'),
            //array('title' => 'History Upline Sponsor', 'description' => '', 'link' => 'voffice/network/upline_sponsor'),
            //array('title' => 'History Upline Pasangan', 'description' => '', 'link' => 'voffice/network/upline_match'),
        );
        $sort_id++;
        
        $par_menu[$sort_id] = array('title' => 'Komisi', 'description' => '', 'link' => '#', 'class' => 'fa fa-gift');
        $sub_menu[$sort_id] = array(
            array('title' => 'Status Komisi', 'description' => '', 'link' => 'voffice/bonus/show'),
            array('title' => 'History Komisi', 'description' => '', 'link' => 'voffice/bonus/log'),
            array('title' => 'History Transfer', 'description' => '', 'link' => 'voffice/bonus/transfer'),
        );
        $sort_id++;
        
        $par_menu[$sort_id] = array('title' => 'Reward', 'description' => '', 'link' => '#', 'class' => 'fa fa-trophy');
        $sub_menu[$sort_id] = array(
            array('title' => 'Data Reward', 'description' => '', 'link' => 'voffice/reward/show'),
            array('title' => 'History Reward', 'description' => '', 'link' => 'voffice/reward/log'),
        );
        $sort_id++;
        
        // $par_menu[$sort_id] = array('title' => 'Report Peringkat', 'description' => '', 'link' => 'voffice/peringkat', 'class' => 'fa fa-info-circle');
        // $sort_id++;
        
        // $par_menu[$sort_id] = array('title' => 'Informasi', 'description' => '', 'link' => 'voffice/dashboard/information', 'class' => 'fa fa-info-circle');
        // $sort_id++;
        
        $par_menu[$sort_id] = array('title' => 'File Download', 'description' => '', 'link' => 'voffice/downloads/show', 'class' => 'fa fa-cloud-download ');
        $sort_id++;
      
        // $par_menu[$sort_id] = array('title' => 'Tutorial', 'description' => '', 'link' => '#', 'class' => 'fa fa-book');
        // $sub_menu[$sort_id] = array(
        //     array('title' => 'Registrasi Member Baru', 'description' => '', 'link' => 'voffice/page/view/21'),
        //     array('title' => 'Ubah Password', 'description' => '', 'link' => 'voffice/page/view/22'),
        //     array('title' => 'Ubah Profil Member', 'description' => '', 'link' => 'voffice/page/view/23'),
        //     array('title' => 'Mengirim Testimoni', 'description' => '', 'link' => 'voffice/page/view/24'),
        // );
        // $sort_id++;
        
        $par_menu[$sort_id] = array('title' => 'Pesan', 'description' => '', 'link' => 'voffice/message', 'class' => 'fa fa-envelope');
        $sort_id++;
        
        $par_menu[$sort_id] = array('title' => 'Testimony', 'description' => '', 'link' => 'voffice/testimony', 'class' => 'fa fa-commenting');
        $sort_id++;
        
        $generate_menu = '';
        $generate_menu .= '<ul class="sidebar-menu">';
        $generate_menu .= '
            <li class="header">MENU UTAMA</li>
            <li class="active treeview">
                <a href="' . base_url() . 'voffice/dashboard/show">
                    <i class="fa fa-dashboard"></i> 
                    <span>Dashboard</span> 
                </a>
            </li>
        ';

        // cari root menu
        if (is_array($par_menu)) {

            // ekstrak root menu
            foreach ($par_menu as $rootmenu_sort => $rootmenu_value) {
                if(array_key_exists($rootmenu_sort, $sub_menu)) {
                    $rootmenu_link = '#';
                } else {
                    if($rootmenu_value['link'] == '#') {
                        $rootmenu_link = '#';
                    } else {
                        $rootmenu_link = base_url() . $rootmenu_value['link'];
                    }
                }

                // cari submenu 1
                if(array_key_exists($rootmenu_sort, $sub_menu)) {
                    $generate_menu .= '
                        <li class="treeview" title="' . $rootmenu_value['description'] . '">
                            <a href="' . $rootmenu_link . '">
                                <i class="' . $rootmenu_value['class'] . '"></i> 
                                <span>' . $rootmenu_value['title'] . '</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                    ';

                    // ekstrak submenu 1 yang par_id adalah menu_id dari root menu
                    foreach ($sub_menu[$rootmenu_sort] as $submenu_1_sort => $submenu_1_value) {
                        if($submenu_1_value['link'] == '#') {
                            $submenu_1_link = '#';
                        } else {
                            $submenu_1_link = base_url() . $submenu_1_value['link'];
                        }
                        
                        if(isset($submenu_1_value['class']) && $submenu_1_value['class'] != '') {
                            $submenu_1_class = $submenu_1_value['class'];
                        } else {
                            $submenu_1_class = 'fa fa-caret-right';
                        }
                        
                        $generate_menu .= '<li title="' . $submenu_1_value['description'] . '"><a href="' . $submenu_1_link . '"><i class="' . $submenu_1_class . '"></i>' . $submenu_1_value['title'] . '</a></li>';
                    }
                    $generate_menu .= '</ul>';
                } else {
                    $generate_menu .= '
                        <li class="" title="' . $rootmenu_value['description'] . '">
                            <a href="' . $rootmenu_link . '">
                                <i class="' . $rootmenu_value['class'] . '"></i> 
                                <span>' . $rootmenu_value['title'] . '</span>
                            </a>
                    ';
                }
                $generate_menu .= '</li>';
            }
            $generate_menu .= '
                <li>
                    <a href="' . base_url() . 'voffice/logout">
                        <i class="fa fa-power-off"></i> 
                        <span class="title">Log Out</span>
                    </a>
                </li>
            ';
            $generate_menu .= '</ul>';
        }
        ?>
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="<?php echo base_url(); ?>" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini">T<b>S</b>M</span>
                    <!-- logo images for regular state and mobile devices -->
                    <span class="logo-img">
                        <img src="<?php echo base_url(_dir_site_config . $this->site_configuration['logo']); ?>" title="<?php echo $this->site_configuration['title']; ?> " class="img-responsive">
                    </span>
                    <!-- logo for regular state and mobile devices -->
                  
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php echo base_url() . 'media/' . _dir_member . '160/160/' . $profile_image; ?>" class="user-image" alt="<?php echo stripslashes($this->session->userdata('member_name')); ?>">
                                    <span class="hidden-xs"><?php echo $this->session->userdata('network_code'); ?> &middot; <?php echo stripslashes($this->session->userdata('member_name')); ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="<?php echo base_url() . 'media/' . _dir_member . '160/160/' . $profile_image; ?>" class="img-circle" alt="<?php echo stripslashes($this->session->userdata('member_name')); ?>">

                                        <p>
                                            <?php echo $this->session->userdata('network_code'); ?>
                                            <small><?php echo stripslashes($this->session->userdata('member_name')); ?></small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="<?php echo base_url() . 'voffice/systems/profile'; ?>" class="btn btn-default btn-flat">Profil</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="<?php echo base_url(); ?>voffice/systems/password" class="btn btn-default btn-flat">Ubah Password</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo base_url() . 'media/' . _dir_member . '160/160/' . $profile_image; ?>" class="img-circle" alt="<?php echo stripslashes($this->session->userdata('member_name')); ?>">
                        </div>
                        <div class="pull-left info">
                            <p><?php echo $this->session->userdata('network_code'); ?></p>
                            <?php echo stripslashes($this->session->userdata('member_name')); ?>
                        </div>
                    </div>
                    
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <?php echo $generate_menu; ?>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <?php
                        if(isset($page_title)) {
                            echo '<h1>' . $page_title . '</h1>';
                        } else {
                            echo '<h1>&nbsp;</h1>';
                        }
                    ?>
                    <!--
                    <h1>
                        Dashboard
                        <small>Control panel</small>
                    </h1>
                    -->
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url(); ?>voffice/dashboard/show"><i class="fa fa-dashboard"></i>&nbsp; Home</a></li>
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
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <?php
                    if (isset($this->arr_flashdata['confirmation'])) {
                        echo '<div class="row"><div class="col-md-12">' . $this->arr_flashdata['confirmation'] . '</div></div>';
                    }
                    ?>
                    <?php $this->load->view($contents); ?>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <?php echo $this->site_configuration['footer']; ?>
            </footer>

        </div>
        <!-- ./wrapper -->
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- Bootstrap 3.3.6 -->
        <script src="<?php echo $themes_url; ?>/bootstrap/js/bootstrap.min.js"></script>
        <!-- Morris.js charts -->
        <script src="<?php echo $themes_url; ?>/plugins/morris/raphael-min.js"></script>
        <script src="<?php echo $themes_url; ?>/plugins/morris/morris.min.js"></script>
        <!-- Sparkline -->
        <script src="<?php echo $themes_url; ?>/plugins/sparkline/jquery.sparkline.min.js"></script>
        <!-- jvectormap -->
        <script src="<?php echo $themes_url; ?>/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="<?php echo $themes_url; ?>/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <!-- jQuery Knob Chart -->
        <script src="<?php echo $themes_url; ?>/plugins/knob/jquery.knob.js"></script>
        <!-- daterangepicker -->
        <script src="<?php echo $themes_url; ?>/plugins/daterangepicker/moment.min.js"></script>
        <script src="<?php echo $themes_url; ?>/plugins/daterangepicker/daterangepicker.js"></script>
        <!-- datepicker -->
        <script src="<?php echo $themes_url; ?>/plugins/datepicker/bootstrap-datepicker.js"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="<?php echo $themes_url; ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
        <!-- Slimscroll -->
        <script src="<?php echo $themes_url; ?>/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="<?php echo $themes_url; ?>/plugins/fastclick/fastclick.js"></script>
        <!-- bxslider -->
        <script type="text/javascript" src="<?php echo $themes_url; ?>/plugins/bxslider/jquery.bxslider.min.js"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo $themes_url; ?>/dist/js/app.min.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <!--<script src="<?php echo $themes_url; ?>/dist/js/pages/dashboard.js"></script>-->
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo $themes_url; ?>/dist/js/demo.js"></script>
        
        <?php
        if(isset($extra_foot_content)) {
            echo $extra_foot_content;
        }
        ?>
    </body>
</html>
