<?php

/*
 * Backend Modules Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('modules/backend_modules_model');
        $this->load->helper('form');
    }

    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Modul' => 'backend/modules/show',
        );
        
        template('backend', 'modules/backend_modules_list_view', $data);
    }

    function add() {
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Modul' => 'backend/modules/show',
            'Tambah Data Modul' => 'backend/modules/add',
        );
        
        $data['form_action'] = 'backend_service/modules/act_add';
        
        template('backend', 'modules/backend_modules_add_view', $data);
    }

    function edit() {
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Master' => '#',
            'Data Modul' => 'backend/modules/show',
            'Ubah Data Modul' => 'backend/modules/edit/' . $edit_id,
        );
        
        $data['query'] = $this->function_lib->get_detail_data('site_modules', 'modules_id', $edit_id);
        $data['form_action'] = 'backend_service/modules/act_edit';

        template('backend', 'modules/backend_modules_edit_view', $data);
    }

}
