<?php

/*
 * Frontend Links Sidebar Widget
 *
 * @author	Agus Heriyanto
 *              Meychel Danius F. Sambuari
 * @copyright	Copyright (c) 2012, Sigma Solusi Indonesia.
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Links_sidebar_widget extends Widget {

    public function run() {
        $this->load->model("frontend/links_model");

        $themes = $this->site_configuration['themes'];
        $widget_themes = 'themes/' . $themes;

        $sql_links = $this->links_model->get_links(10);
        $data['rs_links'] = $sql_links->result();

        $this->render($widget_themes . '/links_sidebar_widget_view', $data);
    }

}
