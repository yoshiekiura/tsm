<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of frontend_news_mainbar_widget
 *
 * @author Yusuf Rahmanto
 */
class frontend_news_mainbar_widget extends Widget {
    
    public function run() {
        $this->load->model("news/frontend_news_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];
        
        $data['widget_title'] = 'Berita Terbaru';
        $data['widget_sub_title'] = 'Update Lainnya';
        $data['query_primer'] = $this->frontend_news_model->get_news_list(0, 1)->result();
        $data['query_sub'] = $this->frontend_news_model->get_news_list(1, 5)->result();
        
        $this->render($widget_themes . 'frontend_news_mainbar_widget_view', $data);
    }
}

?>
