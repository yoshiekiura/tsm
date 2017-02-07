<?php

/*
 * Frontend Menu Top Widget
 *
 * @author	Agus Heriyanto
 *              Meychel Danius F. Sambuari
 * @copyright	Copyright (c) 2012, Sigma Solusi Indonesia.
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu_top_widget extends Widget {

    public function run() {
        $this->load->model("frontend/common_model");
        
        $themes = $this->site_configuration['themes'];
        $widget_themes = 'themes/' . $themes;

        $sql_menu = $this->common_model->get_menu();
        $data['rs_menu'] = $sql_menu->result();

        $this->render($widget_themes . '/menu_top_widget_view', $data);
    }

}
