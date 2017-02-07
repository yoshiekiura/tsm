<?php

/*
 * Frontend Products Search Widget
 *
 * @author	Agus Heriyanto
 *              Meychel Danius F. Sambuari
 * @copyright	Copyright (c) 2012, Sigma Solusi Indonesia.
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products_search_widget extends Widget {

    public function run() {
        $themes = $this->site_configuration['themes'];
        $widget_themes = 'themes/' . $themes;

        $this->render($widget_themes . '/products_search_widget_view');
    }

}
