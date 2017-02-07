<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <title><?php echo $this->site_configuration['title']; ?></title>
        <meta name="copyright" content="Esoftdream" />
        <meta name="description" content=" Website">
        <meta name="author" content="NetsolMind">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?php echo $themes_url; ?>/images/favicon.ico">

        <!-- CSS -->
        <link href="<?php echo $themes_url; ?>/css/keyboard.css" rel="stylesheet" type="text/css">
        <link href='http://fonts.googleapis.com/css?family=Archivo+Narrow' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Racing+Sans+One' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,900' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Roboto+Slab' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
        <link href="<?php echo $themes_url; ?>/css/newstyle.css" rel="stylesheet" type="text/css">

        <!-- JS -->
        <script src="<?php echo $themes_url; ?>/js/core/jquery-1.7.2.min.js"></script>
        <script src="<?php echo $themes_url; ?>/js/jquery.ui.totop.js"></script>
        <script src="<?php echo $themes_url; ?>/js/jquery.carouFredSel-6.2.0.js"></script>

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <?php
        if(isset($extra_head_content)) {
            echo $extra_head_content;
        }
        ?>
        
    </head>

    <body>

        <div class="wrapper">

            <!-- Header -->
            <header>
                <div class="row-fluid">
                    <div class="span12">					
                        <div class="widget-topnav">
                            <div class="container">

                            </div>
                        </div>						

                        <div class="header-wrapper">
                            <div class="container">
                                <button type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                </button>	

                                <div class="row-fluid">
                                    <div class="span3">
                                        <h1 class="brand" >
                                            <a href="<?php echo base_url();?>">
                                                <img src="<?php echo $themes_url; ?>/images/logo.png" title="your brand" alt="brand">
                                            </a>
                                        </h1>								
                                    </div>

                                    <div class="span9">	
                                        <ul id="top_nav">
                                            <li><a href="<?php echo base_url(); ?>registration"><i class="icon-lock icon-white"></i> Register</a></li></li>
                                            <li><a href="<?php echo base_url(); ?>member"><i class="icon-user icon-white"></i> Login</a></li></li>
                                        </ul>
                                        <div class="navbar pull-right">
                                            <div class="navbar-inner">
                                                <div class="nav-collapse collapse navbar-ex1-collapse pull-right">
                                                    <ul class="nav navbar-nav pull-right">
                                                        <?php widget::run('menu/frontend_menu_top_widget'); ?>													
                                                    </ul>
                                                </div>
                                            </div>										
                                        </div>							
                                    </div>
                                </div>						
                            </div>
                        </div>
                    </div>
                </div>

            </header>
            <!-- End Header -->	

            <!--slider content -->

            <!-- Main Section -->	
            <section id="main-content">			
                <div class="container">				
                    <div class="widget_container">

                        <div id="article">								
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="row-fluid">
                                        <div class="span4">
                                            <div class="clearfix"></div>
                                            
                                            <div class="widget">
                                                <div class="well well-small" id="widget_menu" style="padding-top: 0;">
                                                    <div class="titles">
                                                        <div class="row-fluid">
                                                            <h2>Menu</h2>
                                                        </div>
                                                    </div>
                                                    <ul class="nav nav-tabs nav-stacked">
                                                        <!--widget menu-->
                                                        <?php widget::run('menu/frontend_menu_sidebar_widget'); ?>
                                                    </ul>
                                                </div>										
                                            </div>
                                            <div class="clearfix"></div>

                                            <div class="well well-small" id="widget_support">
                                                <div class="titles">
                                                    <div class="row-fluid">
                                                        <h2>costumers support</h2>
                                                    </div>
                                                </div>
                                                <div style="display: block;">
                                                    <!--widget online support-->
                                                    <?php widget::run('support/frontend_support_sidebar_widget'); ?>

                                                </div>
                                            </div>

                                            <div class="titles">
                                                <div class="row-fluid">
                                                    <h2>testimoni</h2>
                                                </div>
                                            </div>
                                            <div style="display: block; height: 370px;">
                                                <div class="testimonial">
                                                    <ul class="bxslider">
                                                        <!--widget online support-->
                                                        <?php widget::run('testimony/frontend_testimony_sidebar_widget'); ?>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="well well-small" id="widget_statistik">
                                                <div class="titles">
                                                    <div class="row-fluid">
                                                        <h2>statistik</h2>
                                                    </div>
                                                </div>
                                                <div class="well">
                                                    <!--widget online support-->
                                                    <?php widget::run('member/frontend_statistic_sidebar_widget'); ?>							
                                                </div>
                                            </div>
                                        </div>									

                                        <!--===========Isi Contents==========-->
                                        <?php echo $this->session->flashdata('confirmation'); ?>
                                        <?php $this->load->view($contents); ?>
                                        <!--=================================-->

                                    </div>											
                                </div>
                            </div>
                            <div class="clearfix"><br></div>				
                        </div>
                    </div>
                </div>
            </section>
            <!-- End Main Section -->
        </div>

        <!-- Footer -->
        <!-- Footer -->
        <footer>
            <div class="container">
                <div id="bottom-section">
                    <div class="row-fluid">
                        <div class="span8">
                            <!--top member-->
                            <?php widget::run('member/frontend_top_member_footer_widget'); ?>
                        </div>

                        <!--contack-->
                        <div class="widget span4 pull-right" id="widget_contact">
                            <!-- support service -->
                            <div class="row-fluid">
                                <div class="span12">
                                    <h3>Contact Us</h3>
                                    <hr>
                                    <h4><img src="<?php echo $themes_url; ?>/images/call.png" width="58" height="58"><em>0853 999 61000</em></h4>
                                    <h4><img src="<?php echo $themes_url; ?>/images/sms.png" width="58" height="58"><em>0853 999 62000</em></h4>
                                    <h4><img src="<?php echo $themes_url; ?>/images/email.png" width="58" height="58"><em>email@yourdomain.com</em></h4>
                                    <div class="moduletable social">
                                        <div class="mod-menu__social">
                                            <ul class="menu ">
                                                <li class="item-148 firstItem"><a class="twitter" href="#">Twitter</a></li>
                                                <li class="item-146"><a class="facebook" href="#">Facebook</a></li>
                                                <li class="item-147 lastItem"><a class="feed" href="#">Feed</a></li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <br>
                            <!--end contact-->        
                        </div>

                    </div>
                </div>
            </div>

            <!--widget bank-->
            <div style="background:#fff; padding:20px;">
                <div id="widget_rekening">
                    <div class="container">
                        <ul class="list-6">
                            <!--rekening-->
                            <?php widget::run('bank_account/frontend_bank_account_footer_widget'); ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!--end widget bank-->

            <div class="container">	
                <div id="copyright">
                    <div class="footer-border"></div>
                    <div class="copyright">
                        <div class="row-fluid">
                            <div class="span8" style="min-height: 0;">
                                <div id="widget_footer_link">
                                    <?php widget::run('menu/frontend_menu_footer_widget'); ?>
                                </div>						
                            </div>

                            <div class="span4 pull-right" style="min-height: 0;">
                                <p style="text-align: right;">Copyright 2014 <a href="<?php echo base_url();?>">EsoftDream.net</a>. All rights reserved.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#" id="toTop" style="margin-right: 44px; right: 55%; display: block;"><span id="toTopHover" style="opacity: 0;"></span></a>
        </footer>

        <!-- Javascript -->
        <script src="<?php echo $themes_url; ?>/js/core/bootstrap.min.js"></script>

        <script>
            //<![CDATA[
            var mfn_slider_args = {"timeout": 4000, "auto": 1, "pause": 1, "controls": 1};
            //]]>
        </script> 

        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/responsiveslides.js?ver=1.2.0"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/jquery.jcarousel.min.js?ver=1.2.0"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/mfn-offer-slider.js?ver=1.2.0"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/owl.carousel.min.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/jquery.flexslider.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/jquery.tweet.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/bootstrap-tooltip.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/jquery.totemticker.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/jquery.marquee.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/jquery.spritely-0.6.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/pirobox_extended.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/jquery.newsticker.pack.js"></script> 
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/core/jquery-ui.js"></script>	
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/scripts.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/jquery.keyboard.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/jquery.simpleSlider.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/jquery.simpleSlider.effects.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/jquery.pageSlider.js"></script>
        <script type="text/javascript" src="<?php echo $themes_url; ?>/js/newsslide.js"></script>
        <script src="<?php echo $themes_url; ?>/js/jquery.bxslider.min.js" type="text/javascript"></script>
        <script src="<?php echo $themes_url; ?>/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>

        <!--testimonial-->
        <script type="text/javascript">
            $(document).ready(function() {
                $('.bxslider').bxSlider({
                    mode: 'vertical',
                    slideMargin: 3,
                    auto: true
                });
            });
        </script>
        <!--end testimonial-->

        <!--slider-->
        <script type="text/javascript">
            $(document).ready(function() {
                $('#slider').simpleSlider({
                    width: 960,
                    height: 450
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#pagesld').pageSlider({


                });
            });
	</script>
        <!--end of slider-->

        <!--totemticker-->
        <script type="text/javascript">
            $(function() {
                $('.vertical-ticker').totemticker({
                    row_height: '100px',
                    mousestop: true,
                    speed: 800,
                    interval: 2000
                });
            });
        </script>
        <!--end of totemticker-->

        <script type="text/javascript">
            $(document).ready(function() {

                var owl = $("#slider-info");

                owl.owlCarousel({
                    items: 4, //10 items above 1000px browser width
                    itemsDesktop: [1000, 4], //5 items between 1000px and 901px
                    itemsDesktopSmall: [900, 3], // 3 items betweem 900px and 601px
                    itemsTablet: [600, 2], //2 items between 600 and 0;
                    itemsMobile: [300, 1] // itemsMobile disabled - inherit from itemsTablet option

                });

                // Custom Navigation Events
                $(".next").click(function() {
                    owl.trigger('owl.next');
                })
                $(".prev").click(function() {
                    owl.trigger('owl.prev');
                })
            });
        </script>	

        <script>
            $(function() {
                $(".DatePicker").datepicker({
                    numberOfMonths: 2,
                    showButtonPanel: true,
                    dateFormat: 'yy-mm-dd'
                });
            });
        </script>	

        <script type="text/javascript">
            $(document).ready(function() {
                $().piroBox_ext({
                    piro_speed: 900,
                    bg_alpha: 0.1,
                    piro_scroll: true //pirobox always positioned at the center of the page
                });

                $('.carousel').carousel({
                    interval: 4000
                })
            });
        </script>

        <script type="text/javascript">
            (function($) {
                $(document).ready(function() {

                    $('#clouds').pan({fps: 30, speed: 0.7, dir: 'left', depth: 10});
                    $('#clouds').spRelSpeed(8);

                    window.actions = {
                        fly_slowly_forwards: function() {
                            $('#clouds')
                                    .spRelSpeed(10)
                                    .spChangeDir('left');
                        },
                        fly_slowly_backwards: function() {
                            $('#clouds')
                                    .spRelSpeed(10)
                                    .spChangeDir('right');
                        },
                        fly_quickly_forwards: function() {
                            $('#clouds')
                                    .spRelSpeed(30)
                                    .spChangeDir('left');
                        },
                        fly_quickly_backwards: function() {
                            $('#clouds')
                                    .spRelSpeed(30)
                                    .spChangeDir('right');
                        },
                        fly_like_lightning_forwards: function() {
                            $('#clouds')
                                    .spSpeed(40)
                                    .spChangeDir('left');
                        },
                        fly_like_lightning_backwards: function() {

                            $('#clouds')
                                    .spSpeed(40)
                                    .spChangeDir('right');
                        }
                    };

                    window.page = {
                        hide_panels: function() {
                            $('.panel').hide(300);
                        },
                        show_panel: function(el_id) {
                            this.hide_panels();
                            $(el_id).show(300);
                        }
                    }
                });
            })(jQuery);
        </script>

        <script type="text/javascript">
            $(document).ready(
                    function()
                    {
                        $("#side-testimoni").newsTicker();
                    }
            );
        </script>

        <script type="text/javascript">
            <!--
                $(function() {
                // basic version is: $('div.demo marquee').marquee() - but we're doing some sexy extras

                $('marquee').marquee('pointer').mouseover(function() {
                    $(this).trigger('stop');
                }).mouseout(function() {
                    $(this).trigger('start');
                }).mousemove(function(event) {
                    if ($(this).data('drag') == true) {
                        this.scrollLeft = $(this).data('scrollX') + ($(this).data('x') - event.clientX);
                    }
                }).mousedown(function(event) {
                    $(this).data('drag', true).data('x', event.clientX).data('scrollX', this.scrollLeft);
                }).mouseup(function() {
                    $(this).data('drag', false);
                });

            });
            //-->
        </script>	

        <script>
            $(window).load(function() {
                //carufredsel
                $(function() {
                    $('#carousel1').carouFredSel({
                        auto: false,
                        responsive: true,
                        width: '100%',
                        scroll: 1,
                        circular: true,
                        prev: "#prev",
                        next: "#next",
                        items: {
                            width: 280,
                            height: 'auto', //	optionally resize item-height
                            visible: {
                                min: 1,
                                max: 1
                            }
                        },
                        mousewheel: true,
                        swipe: {
                            onMouse: true,
                            onTouch: true
                        }
                    });
                });
            });
        </script>

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
        
        <script>
		//<![CDATA[
		var mfn_slider_args = { "timeout":4000, "auto":1, "pause":1, "controls":1 };
		//]]>
        </script>
        <!--prettyphoto script-->
        <script type="text/javascript" charset="utf-8">
        $(document).ready(function(){
                $("area[rel^='prettyPhoto']").prettyPhoto();

                $(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000, autoplay_slideshow: true});
                $(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});

                $("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
                        custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
                        changepicturecallback: function(){ initialize(); }
                });

                $("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
                        custom_markup: '<div id="bsap_1259344" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
                        changepicturecallback: function(){ _bsap.exec(); }
                });
        });
        </script>
        <!--end prettyphoto script-->
    </body>
</html>
