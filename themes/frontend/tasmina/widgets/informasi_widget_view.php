<!-- widget informasi -->
<div class="widget" id="widget-submenu">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4><span class="bullet"><i class="fa fa-file-text"></i></span>&nbsp; Informasi</h4>
        </div>
        <div class="panel-body">
            <div class="list-group">
                <?php foreach ($sidebar_menu[0] as $key => $menu): ?>
                <?php
                    $target = '';
                    if ($menu->menu_link == '#') {
                        $menu_link = '#';
                    } elseif ($menu->menu_type == 'url') {
                        $menu_link = $menu->menu_link;
                        $target = 'target="_blank"';
                    } else {
                        $menu_link = base_url() . $menu->menu_link;
                    }
                ?>
                <a href="<?php echo $menu_link ?>" <?php echo $target ?> class="list-group-item"><i class="fa fa-chevron-circle-right"></i><?php echo $menu->menu_title ?> </a>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>
<!-- widget informasi -->