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
        <title>Confirm OTP</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta name="MobileOptimized" content="320" />

        <!-- BEGIN GLOBAL MANDATORY STYLES -->          
        <link type="text/css" rel="stylesheet" href="<?php echo $themes_url; ?>/css/bootstrap.css" />
        <!-- END GLOBAL MANDATORY STYLES -->

        <!-- BEGIN THEME STYLES --> 
        <link type="text/css" rel="stylesheet" href="<?php echo $themes_url; ?>/css/keyboard.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo $themes_url; ?>/css/jquery-ui.css" />   
        <link type="text/css" rel="stylesheet" href="<?php echo $themes_url; ?>/css/custom.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo $themes_url; ?>/css/style-responsive.css" />
        <!-- END THEME STYLES -->
        <style>
            #login-form > .loginWarp {
                background: #555555;
                background-color: #555555;
                padding: 30px 20px 20px;
                margin-top: 15%;
            }
        </style>

        <link rel="shortcut icon" href="<?php echo $themes_url; ?>/images/favicon.ico" />
    </head>
    <!-- END HEAD -->

    <body class="page-header-fixed">
        <div class="header navbar navbar-inverse navbar-fixed-top">
            <!-- BEGIN TOP NAVIGATION BAR -->
            <div class="header-inner">
                <!-- PAGE INFO -->  
                <span class="info-brand"><?php echo $this->site_configuration['title']; ?></span>

                <!-- BEGIN LOGO -->  
                <a class="navbar-brand" href="<?php echo base_url();?>">
                    <img src="<?php echo $themes_url; ?>/images/logo.png" alt="logo" class="img-responsive" />
                </a>
                <!-- END LOGO -->

                <!-- BEGIN RESPONSIVE MENU TOGGLER --> 
                <a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <img src="<?php echo $themes_url; ?>/images/menu-toggler.png" alt="" />
                </a> 
                <!-- END RESPONSIVE MENU TOGGLER -->

                <!-- BEGIN TOP NAVIGATION MENU -->
                <ul class="nav navbar-nav pull-right">
                    <li><h5 class="li-titles">CONFIRM OTP - <?php echo $this->site_configuration['title']; ?></h5></li>             
                </ul>
                <!-- END TOP NAVIGATION MENU -->

            </div>
            <!-- END TOP NAVIGATION BAR -->
        </div>

        <div class="clearfix"></div>
        
        <!-- CONTAINER -->
        <div class="page-container">
            <div id="login-form">
                <div class="loginWarp">
                    <?php
                    if (isset($this->arr_flashdata['confirmation'])) {
                        echo '<div class="alert alert-danger">' . $this->arr_flashdata['confirmation'] . '</div>';
                    }
                    ?>
                    <form name="login_form" action="<?php echo base_url() . _backend_login_uri; ?>/act_validation_otp" method="post">
                        <input type="hidden" name="redirect_url" value="<?php echo rawurldecode($this->input->get('redirect_url')); ?>" />
                        <table width="100%" border="0" cellspacing="5px" cellpadding="5px">
                            <tbody>
                                <tr>
                                    <td style="padding-left:10px">
                                        <div style="position: relative;">
                                            <input placeholder="Masukkan Kode OTP..." class="qwerty ui-keyboard-input ui-widget-content ui-corner-all" type="text" name="code_verifikasi"  id="loginUsername" autocomplete="off" aria-haspopup="true" role="textbox">
                                            <img id="icoUsername" class="tooltip" title="Klik untuk membuka Virtual Keyboard" src="<?php echo $themes_url; ?>/images/keyboard.png" style="position: absolute; right:10px; cursor:pointer;" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-left:10px" align="left">
                                        <div class="col-md-6">
                                            <input type="submit" value="Verifikasi" name="submit" id="submit" class="btn btn-lg btn-block btn-primary">
                                            </div>
                                            <div class="col-md-6">
                                               <input type="submit" value="Resend OTP" name="submit" id="submit" class="btn btn-lg btn-block btn-primary">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <!-- END CONTAINER -->

        <!-- LOAD JAVASCRIPT LIBRARY -->
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/jquery-1.9.0.min.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/jquery.keyboard.js"></script>
        
        <script>
            $(function(){
                $('.qwerty:eq(0)').keyboard({
                    openOn   : null,
                    stayOpen : true,
                    layout   : 'custom',
                    customLayout: {
                        'default': [
                            "` 1 2 3 4 5 6 7 8 9 0 - = {bksp}",
                            "q w e r t y u i o p [ ] \\",
                            "a s d f g h j k l ; \'",
                            "{Shift} z x c v b n m , . / {Shift}",
                            "{Cancel} {space} {accept}"
                        ],
                        'shift' : [
                            "~ ! @ # $ % ^ & * ( ) _ + {bksp}",
                            "Q W E R T Y U I O P { } |",
                            "A S D F G H J K L : \"",
                            "{Shift} Z X C V B N M < > ? {Shift}",
                            "{Cancel} {space} {accept}"
                        ]
                    },
                    display : {
                        'accept' : 'OK',
                        'bksp' : 'Backspace'
                    },
                    css : {
                        buttonAction : 'ui-state-active'
                    } ,
                    position : {
                        of : null, // null (attach to input/textarea) or a jQuery object (attach elsewhere)
                        my : 'left top',
                        at : 'left top'
                    }
                });
                $('#icoUsername').click(function(){
                    $('.qwerty:eq(0)').getkeyboard().reveal();
                }); 
                
                $('.qwerty:eq(1)').keyboard({
                    openOn   : null,
                    stayOpen : true,
                    layout   : 'custom',
                    customLayout: {
                        'default': [
                            "` 1 2 3 4 5 6 7 8 9 0 - = {bksp}",
                            "q w e r t y u i o p [ ] \\",
                            "a s d f g h j k l ; \'",
                            "{Shift} z x c v b n m , . / {Shift}",
                            "{Cancel} {space} {accept}"
                        ],
                        'shift' : [
                            "~ ! @ # $ % ^ & * ( ) _ + {bksp}",
                            "Q W E R T Y U I O P { } |",
                            "A S D F G H J K L : \"",
                            "{Shift} Z X C V B N M < > ? {Shift}",
                            "{Cancel} {space} {accept}"
                        ]
                    },
                    display : {
                        'accept' : 'OK',
                        'bksp' : 'Backspace'
                    },
                    css : {
                        buttonAction : 'ui-state-active'
                    },
                    position : {
                        of : null, // null (attach to input/textarea) or a jQuery object (attach elsewhere)
                        my : 'left top',
                        at : 'left top'
                    }
                });
                $('#icoPassword').click(function(){
                    $('.qwerty:eq(1)').getkeyboard().reveal();
                });     
            });
        </script>
        <!-- END JAVASCRIPTS -->
    </body>
</html>