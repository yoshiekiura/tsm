<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of frontend_bank_account_footer_widget
 *
 * @author Yusuf Rahmanto
 */
class frontend_bank_account_footer_widget extends Widget {
    
    public function run() {
        $this->load->model("bank_account/frontend_bank_account_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];
        
        $data['widget_title'] = '';
        $data['query'] = $this->frontend_bank_account_model->get_bank_account_active();
        
        $this->render($widget_themes . 'frontend_bank_account_footer_widget_view', $data);
    }
}

?>
