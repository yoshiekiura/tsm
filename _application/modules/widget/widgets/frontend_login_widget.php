<?php

/**
 * Description of frontend_login_widget
 *
 * @author el-fatih
 */
class frontend_login_widget extends Widget{
    public function run() {
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];

        $this->load->library('authentication');
        $data['is_logged_in'] = $this->authentication->auth_member();
        $this->render($widget_themes . 'login_widget_view', $data);
    }
    
}
