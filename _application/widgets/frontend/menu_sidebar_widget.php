<?php

/*
 * Frontend Menu Sidebar Widget
 *
 * @author	Agus Heriyanto
 *              Meychel Danius F. Sambuari
 * @copyright	Copyright (c) 2012, Sigma Solusi Indonesia.
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu_sidebar_widget extends Widget {

    public function run() {
        $this->load->model("frontend/common_model");
        
        $themes = $this->site_configuration['themes'];
        $widget_themes = 'themes/' . $themes;

        $sql_menu = $this->common_model->get_menu();
        $data['count'] = $sql_menu->num_rows();
        $data['rs_menu'] = $sql_menu->result();

        $this->render($widget_themes . '/menu_sidebar_widget_view', $data);
    }

}
