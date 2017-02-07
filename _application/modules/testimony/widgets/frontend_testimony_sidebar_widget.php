<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of frontend_testimony_sidebar_widget
 *
 * @author Yusuf Rahmanto
 */
class frontend_testimony_sidebar_widget extends Widget {
    
    public function run() { 
        $this->load->model("testimony/frontend_testimony_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];
        
        $data['widget_title'] = 'Testimonial';
        $data['query'] = $this->frontend_testimony_model->get_random_testimony(10)->result();
        
        $this->render($widget_themes . 'frontend_testimony_sidebar_widget_view', $data);
    }
}

?>
