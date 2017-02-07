<?php

/*
 * Frontend Login Footer Widget
 *
 * @author	Yusuf Rahmanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH')) exit('No direct script access allowed');

class frontend_login_footer_widget extends Widget {
    
    public function run() {
        $this->load->model("member/frontend_member_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];
        
        $this->render($widget_themes . 'frontend_login_footer_widget_view', $data);
    }
}

?>
