<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of frontend_bank_account_footer_widget
 *
 * @author Yusuf Rahmanto
 */
class frontend_reward_widget_sidebar extends Widget {
    
    public function run() {
        $this->load->model("reward/frontend_reward_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];
        
        $data['widget_title'] = '';
        $data['query'] = $this->frontend_reward_model->get_reward_active()->result();
        
        $this->render($widget_themes . 'frontend_widget_reward_sidebar_view',$data);
    }
}

?>
