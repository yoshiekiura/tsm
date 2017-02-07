<?php

/**
 * Description of frontend_menu_sidebar_widget
 *
 * @author Yusuf Rahmanto
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
class frontend_menu_sidebar_widget extends Widget {

    public function run() {
        $this->load->model("menu/frontend_menu_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];
        
        $data['widget_title'] = 'Sidebar menu';
        $data['query'] = $this->frontend_menu_model->get_menu_frontend()->result();
        
        $this->render($widget_themes . 'frontend_menu_sidebar_widget_view', $data);
    }
}

?>
