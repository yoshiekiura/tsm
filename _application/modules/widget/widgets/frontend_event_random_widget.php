<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of frontend_news_mainbar_widget
 *
 * @author Yudha Wirawan Sakti
 */
class frontend_event_random_widget extends Widget {
    
    public function run() {
        $this->load->model("widget/widget_model");

        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];
        $data['widget_title'] = 'Berita Terbaru';
        $data['query_primer'] = $this->widget_model->get_event_random($this->uri->segment(3))->result();
        
        $this->render($widget_themes . 'event_random_widget_view', $data);
    }
}

?>
