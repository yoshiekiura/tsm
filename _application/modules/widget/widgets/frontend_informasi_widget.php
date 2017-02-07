<?php

/**
 * Description of frontend_informasi_widget
 *
 * @author Yudha Wirawan S
 */
class frontend_informasi_widget extends Widget {

     public function run() {
        $this->load->model("widget/widget_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];

        $limit = 10;

        $data['widget_title'] = 'Informasi';
        $raw_sidebar_menu = $this->function_lib->get_menu('sidebar');
        $sidebar_menu = array();
        if($raw_sidebar_menu->num_rows() > 0) {
            foreach ($raw_sidebar_menu->result() as $row_menu) {
                $sidebar_menu[$row_menu->menu_par_id][$row_menu->menu_order_by] = $row_menu;
            }
        }
        ksort($sidebar_menu);
        $data['sidebar_menu'] = $sidebar_menu;
        //$data['query'] = $this->widget_model->get_event_list($limit);
        $this->render($widget_themes . 'informasi_widget_view', $data);
    }

}
