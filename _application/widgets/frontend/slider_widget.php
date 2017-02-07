<?php

/*
 * Frontend Slider Widget
 *
 * @author	Agus Heriyanto
 *              Meychel Danius F. Sambuari
 * @copyright	Copyright (c) 2012, Sigma Solusi Indonesia.
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Slider_widget extends Widget {

    public function run() {
        $this->load->model("frontend/slider_model");
        
        $themes = $this->site_configuration['themes'];
        $widget_themes = 'themes/' . $themes;

        $sql_slider = $this->slider_model->get_slider();
        $data['rs_slider'] = $sql_slider->result();
        
        $this->render($widget_themes . '/slider_widget_view', $data);
    }

}
