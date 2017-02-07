<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of frontend_top_member_footer_widget
 *
 * @author Yusuf Rahmanto
 */
class frontend_top_member_footer_widget extends Widget {
    
    public function run() {
        $this->load->model("member/frontend_member_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];
        
        $data['widget_title'] = '';
        $data['new_member'] = $this->frontend_member_model->get_new_member(10)->result();
        $data['top_income'] = $this->frontend_member_model->get_top_income(10)->result();
        $data['top_sponsor'] = $this->frontend_member_model->get_top_sponsor(10)->result();
        
        $this->render($widget_themes . 'frontend_top_member_footer_widget_view', $data);
    }
}

?>
