<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Copyright 2014 EsoftDream.
 */

/**
 * Description of frontend_menu_top_widget
 *
 * @author Yusuf Rahmanto
 */
class frontend_menu_footer_widget extends Widget {

    public function run() {
        $this->load->model("menu/frontend_menu_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];
        
        $data['widget_title'] = 'Top Menu';
        $data['query'] = $this->frontend_menu_model->get_menu_top()->result();
        
        $this->render($widget_themes . 'frontend_menu_footer_widget_view', $data);
    }
}

?>
