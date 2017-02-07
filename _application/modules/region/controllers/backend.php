<?php

/*
 * Backend Region Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('region/backend_region_model');
        $this->load->helper('form');
    }

    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Regional' => 'backend/region/show',
        );
        
        template('backend', 'region/backend_region_list_view', $data);
    }

    function add() {
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Regional' => 'backend/region/show',
            'Tambah Data Regional' => 'backend/region/add',
        );
        
        $data['form_action'] = 'backend_service/region/act_add';
        
        template('backend', 'region/backend_region_add_view', $data);
    }

    function edit() {
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Regional' => 'backend/region/show',
            'Ubah Data Regional' => 'backend/region/edit/' . $edit_id,
        );
        
        $data['query'] = $this->function_lib->get_detail_data('ref_region', 'region_id', $edit_id);
        $data['form_action'] = 'backend_service/region/act_edit';

        template('backend', 'region/backend_region_edit_view', $data);
    }

}
