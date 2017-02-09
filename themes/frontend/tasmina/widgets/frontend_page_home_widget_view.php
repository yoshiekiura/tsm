<div class="jumbotron" id="widget_jumbotron">
    <div class="container">
        <div class="panel">
            <div class="row">
                <div class="col-md-8 col-md-push-2 col-md-pull-2">
                    <div class="panel-body">
                        <h4 class="titles">
                            <strong><?php echo $query->page_home_title ?></strong>
                            <div class="sh"></div>
                        </h4>
                        <?php echo $query->page_home_content ?>
                        <a href="#" class="btn btn-default"><i class="fa fa-ellipsis-v"></i>&nbsp; Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $frontend_widget = new widget(); ?>
<div id="widget_feature">
    <div class="container">
        <ul>
            <?php $frontend_widget->run('widget/frontend_page_widget', 'feature', 3); ?>
            <?php $frontend_widget->run('widget/frontend_page_widget', 'feature', 4); ?>
            <?php $frontend_widget->run('widget/frontend_page_widget', 'feature', 5); ?>
            <?php $frontend_widget->run('widget/frontend_page_widget', 'feature', 6); ?>
        </ul>
    </div>
</div>