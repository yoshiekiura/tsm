<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of frontend_statistic_sidebar_widget
 *
 * @author Yusuf Rahmanto
 */
class frontend_statistic_sidebar_widget extends Widget {
    
    public function run() {
        $this->load->library("statistik",'counter.dat');
        $this->load->model("member/frontend_member_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];
        
        $data['widget_title'] = '';
        $date = date("Y-m-d");
        $data['total_member'] = $this->frontend_member_model->get_total_member();
        $data['member_today'] = $this->frontend_member_model->get_total_member($date);
        
        $this->render($widget_themes . 'frontend_statistic_sidebar_widget_view', $data);
    }
}

?>
