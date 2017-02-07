<?php

/*
 * Frontend Support Contact Widget
 *
 * @author	Agus Heriyanto
 *              Meychel Danius F. Sambuari
 * @copyright	Copyright (c) 2012, Sigma Solusi Indonesia.
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Support_contact_widget extends Widget {

    public function run() {
        $themes = $this->site_configuration['themes'];
        $widget_themes = 'themes/' . $themes;
        $data['themes_url'] = $this->config->item('base_url') . 'themes/' . $themes . '/frontend';

        $this->load->helper("ymstatus");
        $data['contact_yahoo_id'] = $this->site_configuration['contact_yahoo_id'];
        $data['contact_skype_id'] = $this->site_configuration['contact_skype_id'];

        $this->render($widget_themes . '/support_contact_widget_view', $data);
    }

}
