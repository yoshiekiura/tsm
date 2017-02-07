<?php

/*
 * Backend Administrator Group Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('administrator_group/backend_administrator_group_model');
        $this->load->helper('form');
    }

    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Administrator Group' => 'backend/administrator_group/show',
        );
        
        template('backend', 'administrator_group/backend_administrator_group_list_view', $data);
    }

    function add() {
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Administrator Group' => 'backend/administrator_group/show',
            'Tambah Data Administrator Group' => 'backend/administrator_group/add',
        );
        
        $arr_menu_privilege = array();
        $query_menu = $this->function_lib->get_superuser_menu();
        if ($query_menu->num_rows() > 0) {
            foreach ($query_menu->result() as $row_menu) {
                $arr_menu_privilege[$row_menu->administrator_menu_par_id][$row_menu->administrator_menu_order_by] = $row_menu;
            }
        }
        $data['arr_menu_privilege'] = $arr_menu_privilege;

        $type_options = array();
        $type_options['administrator'] = 'Administrator';
        $type_options['superuser'] = 'Superuser';
        $data['type_options'] = $type_options;
        
        $data['form_action'] = 'backend_service/administrator_group/act_add';
        
        template('backend', 'administrator_group/backend_administrator_group_add_view', $data);
    }

    function edit() {
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Administrator Group' => 'backend/administrator_group/show',
            'Ubah Data Administrator Group' => 'backend/administrator_group/edit/' . $edit_id,
        );
        
        $arr_menu_privilege = array();
        $query_menu = $this->function_lib->get_superuser_menu();
        if ($query_menu->num_rows() > 0) {
            foreach ($query_menu->result() as $row_menu) {
                $arr_menu_privilege[$row_menu->administrator_menu_par_id][$row_menu->administrator_menu_order_by] = $row_menu;
            }
        }
        $data['arr_menu_privilege'] = $arr_menu_privilege;

        $type_options = array();
        $type_options['administrator'] = 'Administrator';
        $type_options['superuser'] = 'Superuser';
        $data['type_options'] = $type_options;
        
        $arr_checked_menu = array();
        $query_privilege = $this->backend_administrator_group_model->get_list_privilege($edit_id);
        if ($query_privilege->num_rows() > 0) {
            foreach($query_privilege->result() as $row_privilege) {
                $arr_checked_menu[] = $row_privilege->administrator_menu_id;
            }
        }
        $data['arr_checked_menu'] = $arr_checked_menu;
        
        $data['query'] = $this->backend_administrator_group_model->get_detail($edit_id, $this->session->userdata('administrator_group_type'));
        $data['form_action'] = 'backend_service/administrator_group/act_edit';

        template('backend', 'administrator_group/backend_administrator_group_edit_view', $data);
    }

}
