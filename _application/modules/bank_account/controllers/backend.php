<?php

/*
 * Backend Bank Account Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('bank_account/backend_bank_account_model');
        $this->load->helper('form');
    }

    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Data Rekening' => 'backend/bank_account/show',
        );
        
        $data['bank_grid_options'] = $this->function_lib->get_bank_grid_options();
        
        template('backend', 'bank_account/backend_bank_account_list_view', $data);
    }

    function add() {
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Data Rekening' => 'backend/bank_account/show',
            'Tambah Data Rekening' => 'backend/bank_account/add',
        );
        
        $data['bank_options'] = $this->function_lib->get_bank_options();
        $data['form_action'] = 'backend_service/bank_account/act_add';

        template('backend', 'bank_account/backend_bank_account_add_view', $data);
    }

    function edit() {
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Data Rekening' => 'backend/bank_account/show',
            'Ubah Data Rekening' => 'backend/bank_account/edit/' . $edit_id,
        );
        
        
        $data['bank_options'] = $this->function_lib->get_bank_options();
        $data['query'] = $this->function_lib->get_detail_data('site_bank_account', 'bank_account_id', $edit_id);
        $data['form_action'] = 'backend_service/bank_account/act_edit';

        template('backend', 'bank_account/backend_bank_account_edit_view', $data);
    }

}












