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

class Bank_account_sidebar_widget extends Widget {

    public function run() {
        $this->load->model("frontend/bank_account_model");

        $themes = $this->site_configuration['themes'];
        $widget_themes = 'themes/' . $themes;

        $sql_bank_account = $this->bank_account_model->get_bank_account();
        $data['count'] = $sql_bank_account->num_rows();
        $data['rs_bank_account'] = $sql_bank_account->result();

        $this->render($widget_themes . '/bank_account_sidebar_widget_view', $data);
    }

}
