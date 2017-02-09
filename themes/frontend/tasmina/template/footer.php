<?php $frontend_widget = new widget(); ?>
<!-- Footer -->
<footer>
    <div id="block-support">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="footer-address">
                        <h4 class="title">Kantor Pusat</h4>
                        <p>
                            <span><strong>PT. TASBIH SALAM MINA</strong></span>
                            <span><?php echo $this->site_configuration['address']; ?></span>
                        </p>
                        <p>
                            <span><strong>Jam Operasional :</strong></span>
                            <span><?php echo $this->site_configuration['operational_hour']; ?></span>
                        </p>
                    </div>
                </div>

                <div class="col-md-3">
                    <?php $frontend_widget->run('widget/frontend_contact_widget'); ?>
                </div>

                <div class="col-md-2">
                    <?php $frontend_widget->run('menu/frontend_menu_footer_widget', 'optional'); ?>
                </div>

                <div class="col-md-4">
                    <?php $frontend_widget->run('menu/frontend_menu_footer_widget'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

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

<script type="text/javascript" src="<?php echo $themes_url; ?>/js/application.js"></script>  

<?php 
if ($this->site_configuration['zopim_chat_active']==1) {
    echo $this->site_configuration['zopim_chat_script'];
}
?>
</body>
<!-- END BODY -->
</html>