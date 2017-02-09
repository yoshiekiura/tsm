<?php

/**
 * Description of frontend_news_widget
 *
 * @author el-fatih
 */
class frontend_news_widget extends Widget {

    public function run() {
        $this->load->model("widget/widget_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];
        $this->load->library('pagination');

        $data['widget_title'] = 'Berita';
        $data['query'] = $this->widget_model->get_news_list(0, 7);
        $this->render($widget_themes . 'news_widget_view', $data);
    }

    public function artikel() {
        $this->load->model("widget/widget_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];
        $this->load->library('pagination');

        $data['widget_title'] = 'Berita';
        $data['query'] = $this->widget_model->get_news_list(0, 7, 1);
        $this->render($widget_themes . 'news_widget_view', $data);
    }

    public function tausiyah() {
        $this->load->model("widget/widget_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];
        $this->load->library('pagination');

        $data['widget_title'] = 'Tausiyah';
        $data['query'] = $this->widget_model->get_news_list(0, 7, 2);
        $this->render($widget_themes . 'tausiyah_widget_view', $data);
    }

}
