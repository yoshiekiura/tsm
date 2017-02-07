<?php

/*
 * Frontend News Sidebar Widget
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Frontend_news_sidebar_widget extends Widget {

    public function run() {
        $this->load->model("news/frontend_news_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];
        
        $data['widget_title'] = 'Berita Terbaru';
        $data['query'] = $this->frontend_news_model->get_news_list(0, 6)->result();
        
        $this->render($widget_themes . 'frontend_news_sidebar_widget_view', $data);
    }

}
