<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Copyright 2014 EsoftDream.
 */

/**
 * Description of frontend_catalog_sidebar_widget
 *
 * @author Yusuf Rahmanto
 */
class frontend_catalog_mainbar_widget extends Widget {
    
    public function run() {
        $this->load->model("catalog/frontend_catalog_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];
        
        $data['widget_title'] = 'Featured Product';
        $data['query'] = $this->frontend_catalog_model->get_random_catalog(3)->result();
        
        $this->render($widget_themes . 'frontend_catalog_mainbar_widget_view', $data);
    }
}

?>
