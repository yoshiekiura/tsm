<?php

/*
 * Backend Province Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('province/backend_province_model');
        $this->load->helper('form');
    }

    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Propinsi' => 'backend/province/show',
        );
        
        $data['region_grid_options'] = $this->function_lib->get_region_grid_options();
        
        template('backend', 'province/backend_province_list_view', $data);
    }

    function add() {
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Propinsi' => 'backend/province/show',
            'Tambah Data Propinsi' => 'backend/province/add',
        );
        
        
        $data['region_options'] = $this->function_lib->get_region_options();
        $data['form_action'] = 'backend_service/province/act_add';
        
        template('backend', 'province/backend_province_add_view', $data);
    }

    function edit() {
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Propinsi' => 'backend/province/show',
            'Ubah Data Propinsi' => 'backend/province/edit/' . $edit_id,
        );
        
        $data['region_options'] = $this->function_lib->get_region_options();
        $data['query'] = $this->function_lib->get_detail_data('ref_province', 'province_id', $edit_id);
        $data['form_action'] = 'backend_service/province/act_edit';

        template('backend', 'province/backend_province_edit_view', $data);
    }

}
