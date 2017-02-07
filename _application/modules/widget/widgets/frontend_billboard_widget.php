<?php

/**
 * Description of frontend_billboard_widget
 *
 * @author el-fatih
 */
class frontend_billboard_widget extends Widget {

    public function run() {
//        $this->load->model("widget/widget_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];
//
//        $data['widget_title'] = '';
//        $data['query'] = $this->widget_model->get_slider_active()->result();

        $this->render($widget_themes . 'billboard_widget_view', $data);
    }

}
