<?php

/*
 * Frontend Language Widget
 *
 * @author	Agus Heriyanto
 *              Meychel Danius F. Sambuari
 * @copyright	Copyright (c) 2012, Sigma Solusi Indonesia.
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Language_widget extends Widget {

    public function run() {
        $themes = $this->site_configuration['themes'];
        $widget_themes = 'themes/' . $themes;
        $data['themes_url'] = $this->config->item('base_url') . 'themes/' . $themes . '/frontend';
        
        if($this->session->userdata('language') == 1) {
            $data['language_code'] = $this->site_configuration['language_code_2'];
            $data['language_icon'] = $this->site_configuration['language_icon_2'];
            $data['language_name'] = $this->site_configuration['language_2'];
        } else {
            $data['language_code'] = $this->site_configuration['language_code_1'];
            $data['language_icon'] = $this->site_configuration['language_icon_1'];
            $data['language_name'] = $this->site_configuration['language_1'];
        }

        $this->render($widget_themes . '/language_widget_view', $data);
    }

}
