<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Copyright 2014 EsoftDream.
 */

/**
 * Description of frontend_menu_top_widget
 *
 * @author Yusuf Rahmanto
 */
class frontend_menu_top_widget extends Widget {

    public function run() {
        $this->load->model("menu/frontend_menu_model");
        $widget_themes = 'themes/frontend/' . $this->site_configuration['frontend_themes'] . '/widgets/';
        $data['themes_url'] = 'themes/frontend/' . $this->site_configuration['frontend_themes'];
        
        $data['widget_title'] = 'Top Menu';
        $query_menu = $this->frontend_menu_model->get_menu_top();

        $arr_menu = array();
        if($query_menu->num_rows() > 0) {
            foreach ($query_menu->result() as $row_menu) {
                $arr_menu[$row_menu->menu_par_id][$row_menu->menu_order_by] = $row_menu;
            }
        }
        $data['arr_menu'] = $arr_menu;
        
        $this->render($widget_themes . 'frontend_menu_top_widget_view', $data);
    }
}

?>
