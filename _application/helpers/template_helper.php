<?php

/*
 * Template Helper
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------

if (!defined('BASEPATH')) exit('No direct script access allowed');

function template($user = 'frontend', $views = '', $data = array()) {
    $CI = & get_instance();
    
    switch ($user) {
        case "backend":
            $themes = $CI->site_configuration['backend_themes'];
            if ($views == 'login') {
                $template_file = 'template_login';
            } elseif ($views == 'confirm_otp') {
                $template_file = 'template_confirm_otp';
            } else {
                if($CI->session->userdata('administrator_group_type') == 'superuser') {
                    $query_menu = $CI->function_lib->get_superuser_menu();
                } else {
                    $query_menu = $CI->function_lib->get_administrator_menu($CI->session->userdata('administrator_group_id'));
                }

                $arr_menu = array();
                if($query_menu->num_rows() > 0) {
                    foreach ($query_menu->result() as $row_menu) {
                        $arr_menu[$row_menu->administrator_menu_par_id][$row_menu->administrator_menu_order_by] = $row_menu;
                    }
                }
                $data['arr_menu'] = $arr_menu;
                $template_file = 'template';
            }
            $folder = 'backend';
            break;
            
        case "member":
            $themes = $CI->site_configuration['member_themes'];
            if ($views == 'login') {
                $template_file = 'template_login';
            } else {
                $template_file = 'template';
            }
            $folder = 'member';
            break;
            
        case "blank":
            $template_file = 'blank';
            break;
        
        default:
            $themes = $CI->site_configuration['frontend_themes'];
            if($views == 'page/frontend_page_home_view') {
                $template_file = 'template_home';
            } elseif ($views == 'login') {
                $template_file = 'login';
            } else {
                $template_file = 'template';
            }
            $data['menu_top'] = $CI->function_lib->get_menu('top');
            $data['menu_sidebar'] = $CI->function_lib->get_menu('sidebar');
            $data['menu_bottom'] = $CI->function_lib->get_menu('bottom');
            $data['menu_middle'] = $CI->function_lib->get_menu('middle');
            $folder = 'frontend';
            break;
    }

    if($template_file == 'blank') {
        $CI->load->view($views, $data);
    } else {
        $data['themes_url'] = $CI->config->item('base_url') . 'themes/' . $folder . '/' . $themes;
        $data['contents'] = $views;
        $CI->load->custom_view('themes/' . $folder . '/' . $themes . '/', $template_file, $data);
    }
    
}

