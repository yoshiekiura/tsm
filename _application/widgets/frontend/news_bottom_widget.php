<?php

/*
 * Frontend News Bottom Widget
 *
 * @author	Agus Heriyanto
 *              Meychel Danius F. Sambuari
 * @copyright	Copyright (c) 2012, Sigma Solusi Indonesia.
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class News_bottom_widget extends Widget {

    public function run() {
        $this->load->model("frontend/news_model");

        $themes = $this->site_configuration['themes'];
        $widget_themes = 'themes/' . $themes;
        
        $data['query_news_random'] = $this->news_model->get_random_news();

        $offset = 0;
        $limit = 5;
        $sql_news = $this->news_model->get_news_list(0, 10);
        $data['rs_news'] = $sql_news->result();

        $this->render($widget_themes . '/news_bottom_widget_view', $data);
    }

}
