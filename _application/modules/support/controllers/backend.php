<?php

/*
 * Backend Support Controller
 *
 * @author	Agus Heriyanto
 * @copyright	Copyright (c) 2014, Esoftdream.net
 */

// -----------------------------------------------------------------------------
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('support/backend_support_model');
        $this->load->helper('form');
    }

    function index() {
        $this->show();
    }

    function show() {
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Online Support' => 'backend/support/show',
        );
        
        template('backend', 'support/backend_support_list_view', $data);
    }

    function add() {
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Online Support' => 'backend/support/show',
            'Tambah Online Support' => 'backend/support/add',
        );
        
        $data['form_action'] = 'backend_service/support/act_add';

        template('backend', 'support/backend_support_add_view', $data);
    }

    function edit() {
        $edit_id = $this->uri->segment(4);
        
        $data['arr_breadcrumbs'] = array(
            'Pengelolaan Web' => '#',
            'Online Support' => 'backend/support/show',
            'Ubah Online Support' => 'backend/support/edit/' . $edit_id,
        );
        
        $data['query'] = $this->function_lib->get_detail_data('site_support', 'support_id', $edit_id);
        $data['form_action'] = 'backend_service/support/act_edit';

        template('backend', 'support/backend_support_edit_view', $data);
    }

}

