<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of frontend_support_sidebar_widget
 *
 * @author Yusuf Rahmanto
 */
class frontend_support_sidebar_widget extends Widget {
    
    public function run() {
        $this->load->model("support/frontend_support_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];
        
        $data['widget_title'] = '';
        $data['query'] = $this->frontend_support_model->get_support_active()->result();
        
        $this->render($widget_themes . 'frontend_support_sidebar_widget_view', $data);
    }
}

?>
