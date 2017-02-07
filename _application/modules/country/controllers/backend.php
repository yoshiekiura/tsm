<?php

/*
 * Backend Country Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('country/backend_country_model');
        $this->load->helper('form');
    }

    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Negara' => 'backend/country/show',
        );
        
        template('backend', 'country/backend_country_list_view', $data);
    }

    function add() {
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Negara' => 'backend/country/show',
            'Tambah Data Negara' => 'backend/country/add',
        );
        
        $data['form_action'] = 'backend_service/country/act_add';
        
        template('backend', 'country/backend_country_add_view', $data);
    }

    function edit() {
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Negara' => 'backend/country/show',
            'Ubah Data Negara' => 'backend/country/edit/' . $edit_id,
        );
        
        $data['query'] = $this->function_lib->get_detail_data('ref_country', 'country_id', $edit_id);
        $data['form_action'] = 'backend_service/country/act_edit';

        template('backend', 'country/backend_country_edit_view', $data);
    }

}
