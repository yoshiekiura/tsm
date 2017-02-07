<?php

/**
 * Description of frontend_member_widget
 *
 * @author el-fatih
 */
class frontend_member_widget extends Widget{
    public function run() {
        $this->load->model("widget/widget_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];

        $data['widget_title'] = '';
        $data['query'] = $this->widget_model->get_new_member();
        $data['top_income'] = $this->widget_model->get_top_income('','',10);
        $data['top_sponsor'] = $this->widget_model->get_top_sponsor('','', 10);

        $this->render($widget_themes . 'member_widget_view',$data);
    }
}
