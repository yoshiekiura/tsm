<?php

/**
 * Description of frontend_left_promo_widget
 *
 * @author Yudha Wirawan S
 */
class frontend_left_promo_widget extends Widget {

     public function run() {
        $this->load->model("widget/widget_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];

        $data['widget_title'] = 'Promo';
        $data['query'] = $this->widget_model->get_left_promo(5);
        $this->render($widget_themes . 'left_promo_widget_view', $data);
    }

}
