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

        //pagination
        $offset = (int) $this->uri->segment(3, 0);
        $limit = 10;
        $config['base_url'] = site_url('news/show');
        $config['total_rows'] = $this->widget_model->get_news_list(0, 10000)->num_rows();
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $data['widget_title'] = 'Berita';
        $data['query'] = $this->widget_model->get_news_list($offset, $limit);
        $this->render($widget_themes . 'news_widget_view', $data);
    }

}
