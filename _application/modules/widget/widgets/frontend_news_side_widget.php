
<?php

/**
 * Description of frontend_news_side_widget
 *
 * @author Yudha Wirawan S
 */
class frontend_news_side_widget extends Widget {

     public function run() {
        $this->load->model("widget/widget_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];

        $data['widget_title'] = 'Informasi';
        $data['query'] = $this->widget_model->get_news_side();
        $this->render($widget_themes . 'news_side_widget_view', $data);
    }

}
