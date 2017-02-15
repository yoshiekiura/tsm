<!DOCTYPE html>

<!-- 
    Version : 3.0
    Author  : Esoftdream
    Website : http://www.esoftdream.net/
    Contact : +62 274 452155
    Copyright (c) 2006-2014 
-->

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"> <!--<![endif]-->

<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title><?php echo $this->site_configuration['title']; ?></title>

    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!-- Mobile viewport optimized: h5bp.com/viewport -->
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="MobileOptimized" content="320" />

    <!-- BEGIN GLOBAL MANDATORY STYLES -->          
    <link href="<?php echo $themes_url ?>/css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN THEME STYLES --> 
    <link href="<?php echo $themes_url ?>/css/imports.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $themes_url ?>/css/custom.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $themes_url ?>/css/responsive.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->

    <!-- JQUERY LIBRARY -->
    <script type='text/javascript' src="<?php echo $themes_url ?>/js/jquery.min.js"></script>
    <!-- JQUERY LIBRARY -->

    <link rel="shortcut icon" href="<?php echo $themes_url ?>/images/favicon.ico" />
</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->
<body class="page">

    <!-- Main -->
    <div id="main-container">
        <div id="error_page">
            <div class="content">
                <a href="<?php echo base_url() ?>">
                    <img src="<?php echo base_url(_dir_site_config . $this->site_configuration['logo']); ?>" class="err_logo" alt="<?php echo $this->site_configuration['title']; ?>">
                    <h1>404</h1>
                </a>
                <h4>Halaman Tidak Ditemukan!</h4>
                <h5>Kembali ke beranda <a href="<?php echo base_url() ?>"><?php echo $_SERVER['SERVER_NAME'] ?></a></h5>
            </div>
        </div>
        
        <script type="text/javascript">
            var Hw = $(window).height();
            $('#error_page').height(Hw-20);
        </script>
    </div>
    <!-- /Main -->

    <!-- Footer -->
    <footer>
        <div class="block-copyright">
            <div class="container">
                <div class="topclick tips" title="" data-original-title="Back on TOP"><i class="fa fa-arrow-circle-up"></i></div>
                <span><?php echo $this->site_configuration['footer']; ?></span>
            </div>
        </div>
    </footer>
    <!-- /Footer -->

    <script type="text/javascript" src="<?php echo $themes_url; ?>/js/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="<?php echo $themes_url; ?>/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $themes_url; ?>/js/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="<?php echo $themes_url; ?>/js/prettyphoto/jquery.prettyPhoto.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo $themes_url; ?>/js/jquery.bxslider.min.js"></script>
    <script type="text/javascript" src="<?php echo $themes_url; ?>/js/jquery-events-frame.js"></script>
    <script type="text/javascript" src="<?php echo $themes_url; ?>/js/jparallax.js"></script>
    <script type="text/javascript" src="<?php echo $themes_url; ?>/js/jquery.slimscroll.min.js"></script>

    <script type="text/javascript" src="<?php echo $themes_url; ?>/js/application.js"></script>  

    <?php 
    if ($this->site_configuration['zopim_chat_active']==1) {
        echo $this->site_configuration['zopim_chat_script'];
    }
    ?>
</body>
<!-- END BODY -->
</html>