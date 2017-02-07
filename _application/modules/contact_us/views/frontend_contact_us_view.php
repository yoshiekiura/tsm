<div class="panel panel-default">
    <div class="panel-heading">
        <h4 style="padding-bottom: 0;">
            <a data-toggle="collapse" data-parent="#accordion" href="#col-main-office" style="display: block; font-weight: bolder;">
                <img src="<?php echo $themes_url; ?>/images/icon_shop.png">&nbsp;&nbsp; Kantor Pusat
            </a>
        </h4>
    </div>
    <div id="col-main-office" class="panel-collapse collapse in">
        <div class="panel-body">
            <div class="row">
                <br>
                <div class="col-md-12">
                <?php 
                    if(!empty($query)){
                        foreach($query as $row){
                            
                        echo $row->contact_us_content;
                        }
                    }
                ?>
                    <?php //Widget::run('support/frontend_support_sidebar_widget'); ?>
                    <br><br>
                </div>
            </div>
        </div>
    </div>
</div>



