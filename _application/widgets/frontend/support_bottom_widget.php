<?php

/*
 * Frontend Support Bottom Widget
 *
 * @author	Agus Heriyanto
 *              Meychel Danius F. Sambuari
 * @copyright	Copyright (c) 2012, Sigma Solusi Indonesia.
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Support_bottom_widget extends Widget {

    public function run() {
        $themes = $this->site_configuration['themes'];
        $widget_themes = 'themes/' . $themes;
        $data['themes_url'] = $this->config->item('base_url') . 'themes/' . $themes . '/frontend';

        $this->load->model("frontend/support_model");
        $this->load->helper("ymstatus");

        $sql_support = $this->support_model->get_support();
        $data['count'] = $sql_support->num_rows();
        $data['rs_support'] = $sql_support->result();

        $this->render($widget_themes . '/support_bottom_widget_view', $data);
    }

}
