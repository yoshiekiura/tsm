<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of frontend_page_home_mainbar_widget
 *
 * @author Yusuf Rahmanto
 */
class frontend_page_home_mainbar_widget extends Widget {
    
    public function run() {
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];
        
        $data['widget_title'] = 'Hompage';
        $data['query'] = $this->function_lib->get_detail_data('site_page_home', 'page_home_location', 'frontend')->row();
        
        $this->render($widget_themes . 'frontend_page_home_widget_view', $data);
    }
}
