<?php $frontend_widget = new widget(); ?><!DOCTYPE html>

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

    <meta name="description" content="<?php echo $this->site_configuration['description']; ?>" />
    <meta name="keywords" content="<?php echo $this->site_configuration['keyword']; ?>" />
    <meta name="author" content="Esoftdream.net"/>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->          
    <link href="<?php echo $themes_url; ?>/css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN THEME STYLES --> 
    <link href="<?php echo $themes_url; ?>/css/imports.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $themes_url; ?>/css/custom.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $themes_url; ?>/css/responsive.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->

    <!-- JQUERY LIBRARY -->
    <script type='text/javascript' src="<?php echo $themes_url; ?>/js/jquery.min.js"></script>
    <!-- JQUERY LIBRARY -->

    <link rel="shortcut icon" href="<?php echo $themes_url; ?>/images/favicon.ico" />
</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->
<body class="page">

    <!-- Header -->
    <header class="page">
        <div class="main-nav">
            <div class="top-info">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-md-push-4">
                            <?php $frontend_widget->run('widget/frontend_contact_widget', 'top'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div id="blok-company">
                    <nav class="navbar navbar-default">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </button>
                            <div class="navbar-brand">
                                <a href="<?php echo base_url() ?>" class="logo" alt="logo"><img src="<?php echo base_url('assets/images/site/' . $this->site_configuration['logo']); ?>   " alt="<?php echo $this->site_configuration['title']; ?>"></a>
                            </div>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="navbar-collapse">
                            <ul class="nav navbar-nav" id="nav">
                                <?php $frontend_widget->run('menu/frontend_menu_top_widget'); ?>
                            </ul>
                        </div><!-- /.navbar-collapse -->
                    </nav>
                </div>
                <!-- blok companies -->
            </div>
        </div>       
    </header>
    <!-- /Header -->
