<?php

/*
 * Frontend Member Menu Widget
 *
 * @author	Agus Heriyanto
 *              Meychel Danius F. Sambuari
 * @copyright	Copyright (c) 2012, Sigma Solusi Indonesia.
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Member_menu_widget extends Widget {

    public function run() {
        $themes = $this->site_configuration['themes'];
        $widget_themes = 'themes/' . $themes;
        
        if ($this->session->userdata('member_id') != null) {
            $data['show_menu'] = true;
        } else {
            $data['show_menu'] = false;
        }

        $this->render($widget_themes . '/member_menu_widget_view', $data);
    }

}
