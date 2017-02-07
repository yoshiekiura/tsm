<?php

/*
 * Backend Administrator Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('administrator/backend_administrator_model');
        $this->load->helper('form');

        $this->file_dir = _dir_administrator;
        $this->allowed_file_type = 'jpg|jpeg|gif|png';
        $this->image_width = 96;
        $this->image_height = 96;
    }

    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Administrator' => 'backend/administrator/show',
        );
        
        $this->load->model('administrator_group/backend_administrator_group_model');
        $administrator_group_grid_options = '';
        $query_administrator_group = $this->backend_administrator_group_model->get_list($this->session->userdata('administrator_group_type'));
        if ($query_administrator_group->num_rows() > 0) {
            foreach ($query_administrator_group->result() as $row_administrator_group) {
                $administrator_group_grid_options .= $row_administrator_group->administrator_group_id . ':' . $row_administrator_group->administrator_group_title . '|';
            }
            $administrator_group_grid_options = rtrim($administrator_group_grid_options, '|');
        }
        $data['administrator_group_grid_options'] = $administrator_group_grid_options;
        
        template('backend', 'administrator/backend_administrator_list_view', $data);
    }

    function add() {
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Administrator' => 'backend/administrator/show',
            'Tambah Data Administrator' => 'backend/administrator/add',
        );
        
        $this->load->model('administrator_group/backend_administrator_group_model');
        $administrator_group_options = array();
        $query_administrator_group = $this->backend_administrator_group_model->get_list($this->session->userdata('administrator_group_type'));
        if ($query_administrator_group->num_rows() > 0) {
            foreach ($query_administrator_group->result() as $row_administrator_group) {
                $administrator_group_options[$row_administrator_group->administrator_group_id] = $row_administrator_group->administrator_group_title;
            }
        }
        $data['administrator_group_options'] = $administrator_group_options;
        
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/administrator/act_add';
        
        template('backend', 'administrator/backend_administrator_add_view', $data);
    }

    function edit() {
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Administrator' => 'backend/administrator/show',
            'Ubah Data Administrator' => 'backend/administrator/edit/' . $edit_id,
        );
        
        $this->load->model('administrator_group/backend_administrator_group_model');
        $administrator_group_options = array();
        $query_administrator_group = $this->backend_administrator_group_model->get_list($this->session->userdata('administrator_group_type'));
        if ($query_administrator_group->num_rows() > 0) {
            foreach ($query_administrator_group->result() as $row_administrator_group) {
                $administrator_group_options[$row_administrator_group->administrator_group_id] = $row_administrator_group->administrator_group_title;
            }
        }
        $data['administrator_group_options'] = $administrator_group_options;
        
        $data['query'] = $this->backend_administrator_model->get_detail($edit_id, $this->session->userdata('administrator_group_type'));
        $data['allowed_file_type'] = str_replace('|', ', ', $this->allowed_file_type);
        $data['image_width'] = $this->image_width;
        $data['image_height'] = $this->image_height;
        $data['form_action'] = 'backend_service/administrator/act_edit';

        template('backend', 'administrator/backend_administrator_edit_view', $data);
    }

    function password() {
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Administrator' => 'backend/administrator/show',
            'Ubah Password Administrator' => 'backend/administrator/password',
        );
        
        $data['query'] = $this->backend_administrator_model->get_detail($edit_id, $this->session->userdata('administrator_group_type'));
        $data['form_action'] = 'backend_service/administrator/act_password';

        template('backend', 'administrator/backend_administrator_password_edit_view', $data);
    }

}
