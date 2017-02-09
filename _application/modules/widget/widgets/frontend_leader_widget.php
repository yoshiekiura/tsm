<?php
/**
 * Description of frontend_leader_widget
 *
 * @author Fahrur Rifai <mfahrurrifai@gmail.com>
 * @copyright Esoftdream.net 2017
 */
class Frontend_leader_widget extends Widget {

     public function run() {
        $this->load->model("widget/widget_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];

        $data['widget_title'] = 'Pembimbing';
        $data['query'] = $this->widget_model->get_data_leader(8);
        $this->render($widget_themes . 'leader_widget_view', $data);
    }

}
