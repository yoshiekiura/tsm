<?php

/**
 * Description of frontend_widget_slider
 *
 * @author el-fatih
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class frontend_slider_widget extends Widget {
    
    public function run() {
        $this->load->model("widget/widget_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];
        
        $data['widget_title'] = '';
        $data['query'] = $this->widget_model->get_slider_active()->result();
        $data['query_count'] = $this->widget_model->get_slider_active()->num_rows();
        
        $this->render($widget_themes . 'slider_widget_view', $data);
    }
}
