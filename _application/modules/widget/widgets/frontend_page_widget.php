<?php

/**
 * Description of frontend_member_widget
 *
 * @author : Yudha Wirawan Sakti
 */
class frontend_page_widget extends Widget{
    public function run() {
        $this->load->model("widget/widget_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];
        $data['widget_title'] = '';
        //$data['query'] = $this->widget_model->get_new_member();

        $this->render($widget_themes . 'page_widget_view',$data);
    }

    public function feature() {
    	$args =func_get_args();
        $this->load->model("widget/widget_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];
        $data['widget_title'] = '';
        $data['query'] = $this->function_lib->get_detail_data('site_page', 'page_id', $args[1]);

        $this->render($widget_themes . 'page_widget_view',$data);
    }
}
