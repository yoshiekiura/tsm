<?php

/*
 * Backend Menu Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('menu/backend_menu_model');
        $this->load->helper('form');
    }

    function index() {
        $this->show();
    }

    function show($menu_par_id = 0) {
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Menu' => 'backend/menu/show',
        );

        $menu_par_title = $this->backend_menu_model->get_menu_title($menu_par_id);
        if($menu_par_id != 0) {
            $data['arr_breadcrumbs']['Data Sub Menu "' . $menu_par_title . '"'] = 'backend/menu/show/' . $menu_par_id;
        }
        
        $data['menu_par_id'] = $menu_par_id;
        $data['menu_par_title'] = $menu_par_title;
        $data['menu_par_id'] = $menu_par_id;
        template('backend', 'menu/backend_menu_list_view', $data);
    }

    function add($menu_par_id = 0) {
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Menu' => 'backend/menu/show',
        );
        
        $this->load->model('modules/backend_modules_model');
        $modules_options = array();
        $query_modules = $this->backend_modules_model->get_list();
        if ($query_modules->num_rows() > 0) {
            foreach ($query_modules->result() as $row_modules) {
                $modules_options[$row_modules->modules_links] = $row_modules->modules_name;
            }
        }
        $data['modules_options'] = $modules_options;
        $data['block_options'] = array('top'=>'Top','sidebar'=>'Sidebar','middle'=>'Middle','bottom'=>'Bottom');

        $this->load->model('page/backend_page_model');
        $page_options = array();
        $query_page = $this->backend_page_model->get_list();
        if ($query_page->num_rows() > 0) {
            foreach ($query_page->result() as $row_page) {
                $page_options['page/view/' . $row_page->page_id . '/' . url_title($row_page->page_title)] = $row_page->page_title;
            }
        }
        $data['page_options'] = $page_options;
        
        $menu_par_title = $this->backend_menu_model->get_menu_title($menu_par_id);
        if($menu_par_id != 0) {
            $data['arr_breadcrumbs']['Data Sub Menu "' . $menu_par_title . '"'] = 'backend/menu/show/' . $menu_par_id;
        }
        $data['arr_breadcrumbs']['Tambah Menu'] = 'backend/menu/add';
        
        $data['menu_par_id'] = $menu_par_id;
        $data['menu_par_title'] = $menu_par_title;
        $data['form_action'] = 'backend_service/menu/act_add';

        template('backend', 'menu/backend_menu_add_view', $data);
    }

    function edit() {
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Menu' => 'backend/menu/show',
        );

        $this->load->model('modules/backend_modules_model');
        $modules_options = array();
        $query_modules = $this->backend_modules_model->get_list();
        if ($query_modules->num_rows() > 0) {
            foreach ($query_modules->result() as $row_modules) {
                $modules_options[$row_modules->modules_links] = $row_modules->modules_name;
            }
        }
        $data['modules_options'] = $modules_options;
        $data['block_options'] = array('top'=>'Top','sidebar'=>'Sidebar','middle'=>'Middle','bottom'=>'Bottom');

        $this->load->model('page/backend_page_model');
        $page_options = array();
        $query_page = $this->backend_page_model->get_list();
        if ($query_page->num_rows() > 0) {
            foreach ($query_page->result() as $row_page) {
                $page_options['page/view/' . $row_page->page_id . '/' . url_title($row_page->page_title)] = $row_page->page_title;
            }
        }
        $data['page_options'] = $page_options;

        $data['menu_id'] = $edit_id;
        $data['query'] = $this->function_lib->get_detail_data('site_menu', 'menu_id', $edit_id);
        if ($data['query']->row('menu_par_id') != 0) {
            $menu_par_id = $data['query']->row('menu_par_id');
            $menu_par_title = $this->backend_menu_model->get_menu_title($menu_par_id);
            $data['arr_breadcrumbs']['Data Sub Menu "' . $menu_par_title . '"'] = 'backend/menu/show/' . $menu_par_id;
        }
        $data['arr_breadcrumbs']['Ubah Menu'] = 'backend/menu/edit/' . $edit_id;
        $data['form_action'] = 'backend_service/menu/act_edit';

        template('backend', 'menu/backend_menu_edit_view', $data);
    }

}

