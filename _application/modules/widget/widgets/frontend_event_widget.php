<?php

/**
 * Description of frontend_event_widget
 *
 * @author el-fatih
 */
class frontend_event_widget extends Widget {

     public function run() {
        $this->load->model("widget/widget_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];

        $data['widget_title'] = 'Event';
        $data['query_pusat'] = $this->widget_model->get_event_list_widget();
        $data['query_cabang'] = $this->widget_model->get_event_list_cabang();
        $this->render($widget_themes . 'event_widget_view', $data);
    }

}
