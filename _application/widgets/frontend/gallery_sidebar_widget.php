<?php

/*
 * Frontend Gallery Sidebar Widget
 *
 * @author	Agus Heriyanto
 *              Meychel Danius F. Sambuari
 * @copyright	Copyright (c) 2012, Sigma Solusi Indonesia.
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gallery_sidebar_widget extends Widget {

    public function run() {
        $this->load->model("frontend/gallery_model");
        
        $themes = $this->site_configuration['themes'];
        $widget_themes = 'themes/' . $themes;
        $data['themes_url'] = $this->config->item('base_url') . 'themes/' . $themes . '/frontend';
        
        $data['query_gallery'] = $this->gallery_model->get_gallery_sample_list('', 10);

        $this->render($widget_themes . '/gallery_sidebar_widget_view', $data);
    }

}
