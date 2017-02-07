<?php

/*
 * Frontend Products Category Widget
 *
 * @author	Agus Heriyanto
 *              Meychel Danius F. Sambuari
 * @copyright	Copyright (c) 2012, Sigma Solusi Indonesia.
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products_category_widget extends Widget {

    public function run() {
        $this->load->model("frontend/products_model");
        
        $themes = $this->site_configuration['themes'];
        $widget_themes = 'themes/' . $themes;
        
        $sql_products_category = $this->products_model->get_products_category_list(0, 10000);
        $data['rs_products_category'] = $sql_products_category->result();

        $this->render($widget_themes . '/products_category_widget_view', $data);
    }

}
