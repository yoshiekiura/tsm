<?php

/*
 * Frontend News Sidebar Widget
 *
 * @author	Agus Heriyanto
 *              Meychel Danius F. Sambuari
 * @copyright	Copyright (c) 2012, Sigma Solusi Indonesia.
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class News_sidebar_widget extends Widget {

    public function run() {
        $this->load->model("frontend/news_model");

        $themes = $this->site_configuration['themes'];
        $widget_themes = 'themes/' . $themes;

        $sql_news = $this->news_model->get_news_list(0, 10);
        $data['count'] = $sql_news->num_rows();
        $data['rs_news'] = $sql_news->result();

        $this->render($widget_themes . '/news_sidebar_widget_view', $data);
    }

}
