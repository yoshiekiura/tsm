<?php

/**
 * Description of frontend_widget_promo
 *
 * @author el-fatih
 */
class frontend_promo_widget extends Widget{
    public function run() {
        $this->load->model("widget/widget_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];
        
        $data['widget_title'] = '';

        $data['query'] = $this->widget_model->get_promo();
        
        $this->render($widget_themes . 'promo_widget_view', $data);
    }
}
