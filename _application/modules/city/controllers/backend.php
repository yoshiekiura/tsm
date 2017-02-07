<?php

/*
 * Backend City Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('city/backend_city_model');
        $this->load->helper('form');
    }

    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Kota / Kabupaten' => 'backend/city/show',
        );
        
        $data['province_grid_options'] = $this->function_lib->get_province_grid_options();
        $data['region_grid_options'] = $this->function_lib->get_region_grid_options();
        
        template('backend', 'city/backend_city_list_view', $data);
    }

    function add() {
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Kota / Kabupaten' => 'backend/city/show',
            'Tambah Data Kota / Kabupaten' => 'backend/city/add',
        );
        
        
        $data['province_options'] = $this->function_lib->get_province_options();
        $data['form_action'] = 'backend_service/city/act_add';
        
        template('backend', 'city/backend_city_add_view', $data);
    }

    function edit() {
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Kota / Kabupaten' => 'backend/city/show',
            'Ubah Data Kota / Kabupaten' => 'backend/city/edit/' . $edit_id,
        );
        
        
        $data['province_options'] = $this->function_lib->get_province_options();
        $data['query'] = $this->function_lib->get_detail_data('ref_city', 'city_id', $edit_id);
        $data['form_action'] = 'backend_service/city/act_edit';

        template('backend', 'city/backend_city_edit_view', $data);
    }

}
