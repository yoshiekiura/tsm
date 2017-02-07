<?php

/*
 * Backend Page Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('page/backend_page_model');
        $this->load->helper('form');
    }

    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Halaman' => 'backend/page/show',
        );
        
        template('backend', 'page/backend_page_list_view', $data);
    }

    function add() {
        $this->load->helper('tinymce');
        
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Halaman' => 'backend/page/show',
            'Tambah Halaman' => 'backend/page/add',
        );
        
        $create_menu_options = array();
        $create_menu_options[1] = 'Ya';
        $create_menu_options[0] = 'Tidak';
        $data['create_menu_options'] = $create_menu_options;
        
        $this->load->model('menu/backend_menu_model');
        $menu_par_id = 0;
        $menu_parent_options = array();
        $menu_parent_options[0] = 'Parent Menu';
        $query_menu = $this->backend_menu_model->get_list($menu_par_id);
        if ($query_menu->num_rows() > 0) {
            foreach ($query_menu->result() as $row_menu) {
                $menu_parent_options[$row_menu->menu_id] = $row_menu->menu_title;
            }
        }
        $data['menu_parent_options'] = $menu_parent_options;
        
        $data['form_action'] = 'backend_service/page/act_add';

        template('backend', 'page/backend_page_add_view', $data);
    }

    function edit() {
        $this->load->helper('tinymce');
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Halaman' => 'backend/page/show',
            'Ubah Halaman' => 'backend/page/edit/' . $edit_id,
        );
        
        $data['query'] = $this->function_lib->get_detail_data('site_page', 'page_id', $edit_id);
        $data['form_action'] = 'backend_service/page/act_edit';

        template('backend', 'page/backend_page_edit_view', $data);
    }

}

